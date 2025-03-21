<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewOrderNotification;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // Si la requête attend une réponse JSON (pour l'API ou AJAX)
        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $orders->items(),
                'meta' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                ]
            ]);
        }

        return view('gestionnaire.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        try {
            // Récupérer le panier de la session
            $cart = Session::get('cart', []);

            // Vérifier si le panier existe et contient des items
            if (empty($cart) || !isset($cart['items']) || !is_array($cart['items']) || count($cart['items']) === 0) {
                Log::warning('Tentative de commande avec un panier vide', [
                    'user_id' => Auth::id(),
                    'cart' => $cart
                ]);

                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Votre panier est vide.'], 400);
                }

                return redirect()->back()->with('error', 'Votre panier est vide.');
            }

            // Valider le prix total
            $request->validate([
                'total_price' => 'required|numeric|min:0',
            ]);

            // Préparer les données de commande
            $items = [];
            $totalPrice = 0;

            foreach ($cart['items'] as $item) {
                // Vérifier que l'item a toutes les propriétés nécessaires
                if (!isset($item['product']) || !isset($item['quantity'])) {
                    Log::warning('Item de panier incomplet', [
                        'item' => $item,
                        'user_id' => Auth::id()
                    ]);
                    continue;
                }

                // Vérifier que la quantité est valide
                $quantity = intval($item['quantity']);
                if ($quantity <= 0) {
                    continue;
                }

                // Vérifier le stock du produit
                $product = Product::findOrFail($item['product']->id);
                if ($product->stock < $quantity) {
                    if ($request->expectsJson()) {
                        return response()->json(['error' => "Le produit {$product->name} n'est plus disponible en quantité suffisante."], 400);
                    }

                    return redirect()->back()->with('error', "Le produit {$product->name} n'est plus disponible en quantité suffisante.");
                }

                // Préparer l'item de commande
                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity
                ];

                // Mettre à jour le stock
                $product->decrement('stock', $quantity);

                // Calculer le prix total
                $totalPrice += $product->price * $quantity;
            }

            // Vérifier que nous avons bien des items
            if (empty($items)) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Impossible de traiter votre commande. Veuillez vérifier votre panier.'], 400);
                }

                return redirect()->back()->with('error', 'Impossible de traiter votre commande. Veuillez vérifier votre panier.');
            }

            // Créer la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'items' => $items,
                'total_price' => $totalPrice, // Utiliser le prix calculé
                'status' => 'en_attente',
            ]);

            // Notifier les gestionnaires
            $gestionnaires = User::role('gestionnaire')->get();
            foreach ($gestionnaires as $gestionnaire) {
                $gestionnaire->notify(new NewOrderNotification($order));
            }

            // Vider le panier
            Session::forget('cart');

            if ($request->expectsJson()) {
                return response()->json($order, 201);
            }

            return redirect()->route('client.orders')->with('success', 'Commande effectuée avec succès! Vous pouvez suivre son statut dans la liste de vos commandes.');
        } catch (\Exception $e) {
            // Log de l'erreur complète
            Log::error('Erreur lors de la création de la commande', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Une erreur est survenue lors du traitement de votre commande. Veuillez réessayer.'], 500);
            }

            return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement de votre commande. Veuillez réessayer.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:en attente,en préparation,prête,payée',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Si le statut passe à "prête", envoi d'un email avec la facture
        if ($request->status === 'prête' && $oldStatus !== 'prête') {
            // Logique d'envoi d'email avec facture PDF à implémenter
            // Mail::to($order->user->email)->send(new OrderReadyMail($order));
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Statut de la commande mis à jour avec succès.']);
        }

        return redirect()->back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function show($id)
    {
        // Récupérer la commande par son ID
        $order = Order::findOrFail($id);

        // Récupérer le paiement associé si la commande est payée
        $payment = null;
        if ($order->status == 'payée') {
            $payment = Payment::where('order_id', $order->id)->latest()->first();
        }

        // Pour les requêtes AJAX ou API
        if (request()->expectsJson() || request()->wantsJson() || request()->ajax()) {
            $data = $order->toArray();
            $data['user'] = $order->user;
            $data['payment'] = $payment;
            return response()->json($data);
        }

        // Vérifier les autorisations
        if (auth()->user()->hasRole('gestionnaire')) {
            return view('gestionnaire.orders.show', compact('order', 'payment'));
        } else if (auth()->id() === $order->user_id) {
            return view('client.order-detail', compact('order'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
