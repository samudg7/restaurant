<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'menu_id' => 'required|exists:menus,id',
            'ingredients' => 'required|array|exists:ingredients,id',
        ]);

        $product = Product::create($data);
        $product->ingredients()->sync($data['ingredients']);

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'menu_id' => 'required|exists:menus,id',
            'ingredients' => 'required|array|exists:ingredients,id',
        ]);

        $product->update($data);
        $product->ingredients()->sync($data['ingredients']);

        return response()->json($product, 200);
    }
}
