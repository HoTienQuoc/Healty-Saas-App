<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PositiveController;


Route::get('/', [AdminController::class,'login'])->name('admin.login');
Route::post('/admin/auth', [AdminController::class,'auth'])->name('admin.auth');


Route::prefix('admin')->middleware('adminMiddleware')->group(function(){
    Route::get('/dashboard', [AdminController::class,'index'])->name('admin.index');
    Route::post('/logout', [AdminController::class,'logout'])->name('admin.logout');

    //product's routes
    Route::resource('products', ProductController::class, [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'update' => 'admin.products.update',
            'edit' => 'admin.products.edit',
            'destroy' => 'admin.products.destroy',
        ]
    ]);

    //positive's routes
    Route::resource('positives', PositiveController::class, [
        'names' => [
            'index' => 'admin.positives.index',
            'create' => 'admin.positives.create',
            'store' => 'admin.positives.store',
            'update' => 'admin.positives.update',
            'edit' => 'admin.positives.edit',
            'destroy' => 'admin.positives.destroy',
        ]
    ]);
});


