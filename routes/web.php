<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Rute Aplikasi)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PUBLIK (PENGUNJUNG BLOG)
// ==========================================
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/posts/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

// ==========================================
// 2. RUTE ADMIN / CMS (DIPROTEKSI LOGIN)
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Artikel (CRUD)
    Route::resource('posts', AdminPostController::class);

    // Manajemen Kategori
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'show', 'edit']);

    // Manajemen Komentar
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/toggle', [AdminCommentController::class, 'toggleApprove'])->name('comments.toggle');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});

// Redirect default dashboard Breeze ke Admin Dashboard
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->middleware(['auth'])->name('dashboard');

// Profil Pengguna (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
