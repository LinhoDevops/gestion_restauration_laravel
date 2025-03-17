<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des produits avec filtres
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

        return view('welcome', compact('products'));
    }
}
