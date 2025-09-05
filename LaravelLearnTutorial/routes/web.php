<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class,'login'])->name('admin.login');
Route::post('/admin/auth', [AdminController::class,'auth'])->name('admin.auth');


Route::prefix('admin')->middleware('adminMiddleware')->group(function(){
    Route::get('/dashboard', [AdminController::class,'index'])->name('admin.index');
    Route::post('/logout', [AdminController::class,'logout'])->name('admin.logout');

});


