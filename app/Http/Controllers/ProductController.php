<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'products' => Product::with('category')->get(),
            'categories' => Category::all()
        ]);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        $imageName = $request->hasFile('image') ? time() . '.' . $request->image->extension() : null;
        if ($imageName) {
            if ($request->image->getSize() > 2048 * 1024) {
                return response()->json(['message' => 'Image size must not exceed 2MB'], 400);
            }
            $request->image->move(public_path('images'), $imageName);
        }

        $product = new Product($request->all());
        if ($imageName) {
            $product->image = url('images/' . $imageName);
        }
        $product->save();

        return response()->json(['product' => $product->load('category')], 201);
    }

    public function update(Request $request, Product $product)
    {
        if (!$request->has('name') || !$request->has('price') || !$request->has('category_id')) {
            return response()->json(['message' => 'name, price, and category_id are required'], 400);
        }

        $imageName = $request->hasFile('image') ? time() . '.' . $request->image->extension() : null;
        if ($imageName) {
            if ($request->image->getSize() > 2048 * 1024) {
                return response()->json(['message' => 'Image size must not exceed 2MB'], 400);
            }
            $request->image->move(public_path('images'), $imageName);
        }

        if ($imageName) {
            // Delete old image
            $oldImage = str_replace(url('/'), public_path(), $product->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            $product->image = url('images/' . $imageName);
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->discount = $request->discount;
        $product->stock = $request->stock;
        $product->save();

        return response()->json(['product' => $product->load('category')], 200);
    }

    public function destroy(Product $product)
    {
        // Delete image file
        $oldImage = str_replace(url('/'), public_path(), $product->image);
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        // Delete product
        $product->delete();

        return response()->json(null, 204);
    }
}
