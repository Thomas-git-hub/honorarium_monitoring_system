<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'index'])->name("login")->name("login");
Route::post('/login', [UserController::class, 'login'])->name("login.user");
Route::get('/registration', [UserController::class, 'registration'])->name("registration");


Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->name("admin_dashboard");
Route::get('/admin_email', [AdminController::class, 'admin_email'])->name("admin_email");
Route::get('/admin_open_email', [AdminController::class, 'admin_open_email'])->name("admin_open_email");
Route::get('/admin_faculty', [AdminController::class, 'admin_faculty'])->name("admin_faculty");
Route::get('/admin_view_faculty', [AdminController::class, 'admin_view_faculty'])->name("admin_view_faculty");
Route::get('/admin_honorarium', [AdminController::class, 'admin_honorarium'])->name("admin_honorarium");

Route::get('/admin_new_entries', [AdminController::class, 'admin_new_entries'])->name("admin_new_entries");
Route::post('/form/submit', [AdminController::class, 'submitForm'])->name('form.submit');

Route::get('/admin_on_queue', [AdminController::class, 'admin_on_queue'])->name('admin_on_queue');
Route::get('/admin_on_hold', [AdminController::class, 'admin_on_hold'])->name('admin_on_hold');
