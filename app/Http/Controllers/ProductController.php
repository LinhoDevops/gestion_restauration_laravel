<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        return response()->json(Product::where('is_active', true)->get());
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('products', 'public') : null;

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock,
            'is_active' => true,
        ]);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->except('image'));

        return response()->json($product);
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        
        if ($product->image) Storage::disk('public')->delete($product->image);

        $product->delete();

        return response()->json(['message' => 'Produit supprimé']);
    }
}
