<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function Add_Product(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'product_name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|in:In Stock,Out of Stock',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('product_page')->with('success', 'Product saved successfully.');
    }

    public function index()
    {
        $products = product::latest('product_id')->get();

        return view('dashboard.product', compact('products')); 
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('dashboard.product_function.editproduct', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|integer',
            'product_name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|in:In Stock,Out of Stock',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('product_images', 'public');
        }

        $product->update($data);

        return redirect()->route('product_page')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('product_page')->with('success', 'Product deleted successfully.');
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $query = Product::join('categories', 'product.category_id', '=', 'categories.category_id');
        $query->select('product.*', 'categories.category_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('category_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('stock_quantity', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%');
            });
        }

        $products = $query->latest('product_id')->get();

        return view('dashboard.product', compact('products'));
    }
    public function order()
    {
        $products =  Product::join('categories', 'product.category_id', '=', 'categories.category_id')
            ->select('product.*', 'categories.category_name')->latest('product_id')->get();

        return view('order', compact('products'));
    }
    public function search_order(Request $request)
    {
        $search = $request->input('search');
        $query = Product::join('categories', 'product.category_id', '=', 'categories.category_id')
            ->select('product.*', 'categories.category_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('category_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('stock_quantity', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%');
            });
        }
        $products = $query->latest('categories.category_id')->get();
        return view('order', compact('products'));
    }
}
