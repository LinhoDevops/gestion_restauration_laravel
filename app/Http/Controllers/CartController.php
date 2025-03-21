<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier
     */
    public function show()
    {
        $cart = Session::get('cart', [
            'items' => [],
            'total' => 0
        ]);

        return view('client.cart', compact('cart'));
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Vérifier si le produit est en stock
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Ce produit n\'est pas disponible en stock.');
        }

        // Vérifier si la quantité demandée est disponible
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'La quantité demandée n\'est pas disponible en stock. Stock actuel: ' . $product->stock);
        }

        // Récupérer le panier actuel ou en créer un nouveau
        $cart = Session::get('cart', [
            'items' => [],
            'total' => 0
        ]);

        // Vérifier si le produit est déjà dans le panier
        $itemIndex = -1;
        foreach ($cart['items'] as $index => $item) {
            if ($item['product']->id == $product->id) {
                $itemIndex = $index;
                break;
            }
        }

        if ($itemIndex !== -1) {
            // Produit déjà dans le panier
            $cart['items'][$itemIndex]['quantity'] += $request->quantity;

            // Vérification du stock et recalcul
            if ($cart['items'][$itemIndex]['quantity'] > $product->stock) {
                $cart['items'][$itemIndex]['quantity'] = $product->stock;
                $this->recalculateCart($cart);
                Session::put('cart', $cart);
                return redirect()->back()->with('warning', 'La quantité a été ajustée au stock disponible.');
            }

            $this->recalculateCart($cart);
            Session::put('cart', $cart);
            return redirect()->back()->with('info', 'Ce burger est déjà dans votre panier. La quantité a été mise à jour.');
        } else {
            // Ajouter le produit au panier
            $cart['items'][] = [
                'product' => $product,
                'quantity' => $request->quantity
            ];
        }

        // Recalculer le total du panier
        $this->recalculateCart($cart);

        Session::put('cart', $cart);

        return redirect()->route('client.catalog')->with('success', 'Produit ajouté au panier! Vous pouvez consulter votre panier pour voir vos articles.');
    }

    /**
     * Met à jour la quantité d'un produit dans le panier
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Vérifier si le produit est en stock
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Ce produit n\'est pas disponible en stock.');
        }

        // Vérifier si la quantité demandée est disponible
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'La quantité demandée n\'est pas disponible en stock. Stock actuel: ' . $product->stock);
        }

        // Récupérer le panier actuel
        $cart = Session::get('cart', [
            'items' => [],
            'total' => 0
        ]);

        // Mettre à jour la quantité du produit
        $itemUpdated = false;
        foreach ($cart['items'] as $index => $item) {
            if ($item['product']->id == $product->id) {
                $cart['items'][$index]['quantity'] = $request->quantity;
                $itemUpdated = true;
                break;
            }
        }

        if (!$itemUpdated) {
            return redirect()->back()->with('error', 'Produit non trouvé dans le panier.');
        }

        // Recalculer le total du panier
        $this->recalculateCart($cart);

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Panier mis à jour!');
    }

    /**
     * Supprime un produit du panier
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Récupérer le panier actuel
        $cart = Session::get('cart', [
            'items' => [],
            'total' => 0
        ]);

        // Supprimer le produit du panier
        foreach ($cart['items'] as $index => $item) {
            if ($item['product']->id == $request->product_id) {
                unset($cart['items'][$index]);
                break;
            }
        }

        // Réindexer le tableau
        $cart['items'] = array_values($cart['items']);

        // Recalculer le total du panier
        $this->recalculateCart($cart);

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Produit retiré du panier!');
    }

    /**
     * Vide le panier
     */
    public function clear()
    {
        Session::forget('cart');

        return redirect()->back()->with('success', 'Panier vidé!');
    }

    /**
     * Recalcule le total du panier
     */
    private function recalculateCart(&$cart)
    {
        $total = 0;

        foreach ($cart['items'] as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        $cart['total'] = $total;
    }
}

