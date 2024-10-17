<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Admin;
use App\Http\Controllers\adminController;


Route::middleware(['auth', 'Admin'])->group(function () {
    Route::get('/admin', [adminController::class, 'index']);
    Route::get('/admin/findUser', [adminController::class, 'findUser']);
    Route::get('/admin/roleChange', [adminController::class, 'roleChange']);
    Route::delete('/admin/userDelete', [adminController::class, 'userDelete']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
