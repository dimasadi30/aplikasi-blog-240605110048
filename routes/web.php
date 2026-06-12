<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\KategoriArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ArticleController;

// Public Routes (No Auth Required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari', [HomeController::class, 'search'])->name('public.search');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])
    ->name('article.show')
    ->where('slug', '^(?!create$|edit$)[a-zA-Z0-9\-]+$');
Route::get('/kategori/{id}', [ArticleController::class, 'category'])->name('category.show')->where('id', '[0-9]+');
Route::post('/artikel/{artikel}/komentar', [KomentarController::class, 'store'])
    ->name('komentar.store')
    ->middleware('throttle:5,1');

// Route untuk search artikel (accessible by all roles including guests)
Route::get('/search', [SearchController::class, 'index'])
    ->name('search.index')
    ->middleware('throttle:30,1'); // 30 searches per minute

Route::get('/search/suggest', [SearchController::class, 'suggest'])
    ->name('search.suggest')
    ->middleware('throttle:60,1'); // 60 suggestions per minute

// Route untuk halaman login
Route::get('/login', [LoginController::class, 'index'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [LoginController::class, 'proses'])
    ->name('login.proses')
    ->middleware(['guest', 'throttle:5,1']);

// Route register
Route::get('/register', [RegisterController::class, 'index'])
    ->name('register')
    ->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store')
    ->middleware(['guest', 'throttle:3,1']);

// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Route yang dilindungi middleware auth
Route::middleware('auth')->group(function () {
    // Route untuk halaman dashboard (accessible by all roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update')
        ->middleware('throttle:5,1');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password')
        ->middleware('throttle:3,1');

    // Routes untuk Penulis dan Admin (artikel management)
    Route::middleware('role:admin|penulis')->group(function () {
        Route::resource('artikel', ArtikelController::class)->except(['show']);
    });

    // Routes untuk Admin only
    Route::middleware('role:admin')->group(function () {
        // Kategori routes (literal /create must be before /{id} dynamic segments)
        Route::resource('kategori', KategoriArtikelController::class)->except(['show']);
        Route::post('/kategori/merge', [KategoriArtikelController::class, 'merge'])
            ->name('kategori.merge');

        // Tag routes
        Route::resource('tags', TagController::class)->except(['show']);
        Route::post('/tags/merge', [TagController::class, 'merge'])
            ->name('tags.merge');

        Route::resource('penulis', PenulisController::class)->except(['show']);
        Route::resource('komentar', KomentarController::class)->only(['index', 'destroy']);
        
        // Comment status management
        Route::post('/komentar/{id}/approve', [KomentarController::class, 'approve'])
            ->name('komentar.approve');
        Route::post('/komentar/{id}/reject', [KomentarController::class, 'reject'])
            ->name('komentar.reject');
        Route::post('/komentar/{id}/spam', [KomentarController::class, 'markAsSpam'])
            ->name('komentar.spam');
        
        // User management routes
        Route::post('/penulis/{id}/suspend', [PenulisController::class, 'suspend'])->name('penulis.suspend');
        Route::post('/penulis/{id}/activate', [PenulisController::class, 'activate'])->name('penulis.activate');
        Route::post('/penulis/{id}/reset-password', [PenulisController::class, 'resetPassword'])->name('penulis.reset-password');
    });
});
