<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlModelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [UrlModelController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {
    Route::get('/create', [UrlModelController::class, 'create'])->name('create.url');
    Route::post('/store', [UrlModelController::class, 'store'])->name('store.url');
    Route::get('/url/show/{id}', [UrlModelController::class, 'show'])->name('urls.show');
    Route::get('/urls/{id}/edit', [UrlModelController::class, 'edit'])->name('urls.edit');
    Route::put('/urls/update/{url}', [UrlModelController::class, 'update'])->name('urls.update');
    Route::delete('/urls/{id}', [UrlModelController::class, 'destroy'])->name('urls.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
