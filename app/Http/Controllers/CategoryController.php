<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::get();
        return response()->json([
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::create($request->all());
        
        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    
}
