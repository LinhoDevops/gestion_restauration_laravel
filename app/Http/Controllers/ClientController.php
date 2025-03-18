<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class ClientController extends Controller
{
    // Catalogue accessible publiquement
    public function catalog(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filtrage par recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtrage par prix
        if ($request->has('price') && $request->price != '') {
            switch ($request->price) {
                case '1':
                    $query->where('price', '<', 5000);
                    break;
                case '2':
                    $query->whereBetween('price', [5000, 8000]);
                    break;
                case '3':
                    $query->where('price', '>', 8000);
                    break;
            }
        }

        // Tri
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(9);

        return view('client.catalog', compact('products'));
    }

    // Détail du produit accessible publiquement
    public function productDetail($id)
    {
        $product = Product::findOrFail($id);
        return view('client.product-detail', compact('product'));
    }

    // Méthode myOrders corrigée pour afficher la liste des commandes de l'utilisateur
    public function myOrders()
    {
        // Vérifiez si l'utilisateur est authentifié
        if (auth()->check()) {
            // Récupérer les commandes de l'utilisateur connecté
            $orders = Order::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('client.my-orders', compact('orders'));
        } else {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos commandes.');
        }
    }


    public function orderDetail($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('client.order-detail', compact('order'));
    }
}
