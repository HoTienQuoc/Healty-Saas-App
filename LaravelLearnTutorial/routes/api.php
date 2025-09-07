<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//products api routes
Route::get('find/product/{product}', [ProductController::class,'findProductById']);
Route::get('search/product/{name}', [ProductController::class,'findProductByName']);
