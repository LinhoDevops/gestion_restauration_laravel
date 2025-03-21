<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('is_active', true)->paginate(10);
        return view('gestionnaire.products.index', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ? basename($imagePath) : null, // Stockez uniquement le nom du fichier
            'stock' => $request->stock,
            'is_active' => true,
        ]);

        return redirect()->route('gestionnaire.products.index')->with('success', 'Produit ajouté avec succès');
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($product->image) {
                    Storage::disk('public')->delete('products/' . $product->image);
                }

                // Stocker la nouvelle image
                $imagePath = $request->file('image')->store('products', 'public');

                // Mettre à jour le chemin de l'image (uniquement le nom du fichier)
                $product->image = basename($imagePath);
            }

            // Mettre à jour les autres champs
            $product->update($request->except('image'));

            return redirect()->route('gestionnaire.products.index')->with('success', 'Produit mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du produit: ' . $e->getMessage());
        }
    }
    public function destroy($id) {
        $product = Product::findOrFail($id);

        try {
            // Supprimer l'image si elle existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Supprimer le produit
            $product->delete();

            return redirect()->route('gestionnaire.products.index')->with('success', 'Produit supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du produit');
        }
    }
}
