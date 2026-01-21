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
        return view('tenant.admin.products', compact('products'));
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
            'active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->all();

        // Manejar la subida de imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('products', $imageName, 'public');
            $data['image'] = 'products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('tenant.admin.products')->with('success', 'Producto creado exitosamente');
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
            'image' => $product->image ? asset('storage/' . $product->image) : null,
            'created_at' => $product->created_at->format('d/m/Y H:i'),
            'updated_at' => $product->updated_at->format('d/m/Y H:i')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'sku' => $product->sku,
            'price' => $product->price,
            'stock' => $product->stock,
            'category' => $product->category,
            'active' => $product->active,
            'image' => $product->image ? asset('storage/' . $product->image) : null
        ]);
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
            'active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->except('image');

        // Manejar la subida de nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('products', $imageName, 'public');
            $data['image'] = 'products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('tenant.admin.products')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Product $product)
    {
        // Soft delete - no elimina la imagen del storage
        $product->delete();
        return redirect()->route('tenant.admin.products')->with('success', 'Producto eliminado exitosamente');
    }
}
