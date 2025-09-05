<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class,'login'])->name('admin.login');

Route::post('/admin/auth', [AdminController::class,'auth'])->name('admin.auth');

Route::get('/dashboard', [AdminController::class,'index'])->name('admin.index');

