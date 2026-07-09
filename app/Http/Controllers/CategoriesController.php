<?php

namespace App\Http\Controllers;
use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function category()
    {
        $categories = categories::latest('id')->get();

        return view('dashboard.category', compact('categories'));
    }
    public function addCategory(Request $request)
    {   
        $request->validate([    
            'category_id' => 'required|integer|unique:categories,category_id',
            'category_name' => 'required|string|max:50',
        ]);

        categories::create([
            'category_id' => $request->category_id,
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('product_category')->with('success', 'Category added successfully.');
    }
    public function destroy($id)
    {
        $category = categories::findOrFail($id);
        $category->delete();

        return redirect()->route('product_category')->with('success', 'Category deleted successfully.');
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $categories = categories::where('category_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('category_id', 'LIKE', '%' . $searchTerm . '%')
            ->latest('id')
            ->get();

        return view('dashboard.category', compact('categories'));
    }
      
}
