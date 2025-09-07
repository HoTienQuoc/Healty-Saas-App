<?php

use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    //user routes
    Route::get('user', function (Request $request) {
        return [
            'user' => UserResource::make($request->user()),
            'access_token' => $request->bearerToken()
        ];
    });
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::get('user/decrement/hearts', [UserController::class, 'decrementUserHearts']);

    //plan routes
    Route::get('plans', [PlanController::class, 'index']);

    //subscription routes
    Route::post('subscribe', [SubscriptionController::class, 'create']);
    Route::post('cancel', [SubscriptionController::class, 'cancel']);

    //history routes
    Route::post('add/history', [HistoryController::class, 'store']);


    //products api routes
    Route::get('find/product/{product}', [ProductController::class, 'findProductById']);
    Route::get('search/product/{name}', [ProductController::class, 'findProductByName']);
});



//user guest routes
Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);
