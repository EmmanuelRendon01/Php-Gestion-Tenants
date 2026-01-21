<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('tenant.products', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|max:255|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        Product::create($request->all());

        return redirect()->route('tenant.products')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description ?? 'Sin descripción',
            'sku' => $product->sku,
            'price' => number_format($product->price, 2),
            'stock' => $product->stock,
            'category' => $product->category ?? 'Sin categoría',
            'active' => $product->active ? 'Activo' : 'Inactivo',
            'created_at' => $product->created_at->format('d/m/Y H:i'),
            'updated_at' => $product->updated_at->format('d/m/Y H:i')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        $product->update($request->all());

        return redirect()->route('tenant.products')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('tenant.products')->with('success', 'Producto eliminado exitosamente');
    }
}
