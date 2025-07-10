<?php

use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\HomeController;

// Geziler route'ları en üstte
Route::middleware(['auth'])->group(function () {
    Route::resource('trips', TripController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});
Route::resource('trips', TripController::class)->only(['index', 'show']);

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard route removed

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Yorum ekleme (sadece giriş yapmış kullanıcılar)
Route::middleware(['auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});
// Yorum silme (sadece admin)
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Beğeni ekleme ve kaldırma (sadece giriş yapmış kullanıcılar)
Route::middleware(['auth'])->group(function () {
    Route::post('/likes/{trip}', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes/{trip}', [LikeController::class, 'destroy'])->name('likes.destroy');
});

// Dil değiştirme
Route::get('/lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

require __DIR__.'/auth.php';
