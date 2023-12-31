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
            'categories' => $categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            })
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

    public function show(string $id) {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Category found',
            'category' => $category
        ]);
    }

    public function destroy(string $id) {
         $category = Category::find($id);
         
         if(!$category) {
             return response()->json([
                 'message' => 'Category not found'
                ], 404);
            }
            
        $category->delete();
        
        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }


}
