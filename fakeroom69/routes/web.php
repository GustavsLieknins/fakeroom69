<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Teacher;
use App\Http\Controllers\adminController;
use App\Http\Controllers\teacherController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CommentController;

Route::post('/admin/userCreate', [adminController::class, 'userCreate'])->middleware('Admin');

Route::middleware(['auth', 'Admin'])->group(function () {
    Route::get('/admin', [adminController::class, 'index']);
    Route::get('/admin/findUser', [adminController::class, 'findUser']);
    Route::get('/admin/roleChange', [adminController::class, 'roleChange']);
    Route::delete('/admin/userDelete', [adminController::class, 'userDelete']);
    
});



Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::post('/calendar/events', [CalendarController::class, 'store'])->name('events.store');



Route::middleware(['auth', 'Teacher'])->group(function () {
    Route::get('/teacher', [teacherController::class, 'index']);
    Route::post('/teacher/create', [teacherController::class, 'create'])->name('create');

    
    Route::post('/teacher/{class}', [teacherController::class, 'store'])->name('tasks.store');
    Route::post('/class/{class}/remove-user/{user}', [IndexController::class, 'removeUser'])->name('class.remove.user');
    
    
    
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get("/class/{id}", [IndexController::class, "show"]);
    Route::get("/showqr/{code}", [IndexController::class, "showqr"])->name('showqr');
    Route::get('/tasks/{task}/{class_id}', [IndexController::class, 'showTask'])->name('show.task');


    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/tasks/{task}/files', [IndexController::class, 'storeFiles'])->name('files.store');
    
    Route::delete('/tasks/{task}/files/{file}', [IndexController::class, 'destroyFile'])->name('files.destroy');
    
});

require __DIR__.'/auth.php';
