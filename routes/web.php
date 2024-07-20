<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'index'])->name("login")->name("login");
Route::get('/registration', [UserController::class, 'registration'])->name("registration");
Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->name("admin_dashboard");
