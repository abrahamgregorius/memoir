<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('user')->group(function() {
    Route::post('/logout', [UserController::class, 'logout']);

    // Category 
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
    
    // Record
    Route::get('/records', [CategoryController::class, 'index']);
    Route::post('/record', [CategoryController::class, 'store']);
    Route::get('/record/{id}', [CategoryController::class, 'show']);
    Route::delete('/record/{id}', [CategoryController::class, 'destroy']);

});