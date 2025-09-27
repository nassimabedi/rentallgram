<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'category' => $category
        ], 201);
    }
    
     // GET /api/categories
     public function index()
     {
         $categories = Category::all();
 
         return response()->json([
             'status' => 'success',
             'categories' => $categories
         ]);
     }
}
