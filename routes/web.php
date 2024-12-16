<?php

use App\Http\Controllers\CreatorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Las rutas utilizadas aquí se usan como apis - Géneros
Route::get('getgenres', [GenreController::class, 'index']);
Route::post('storegenre', [GenreController::class, 'store']);
Route::put('updategenre/{genre}', [GenreController::class, 'update']);
Route::get('genres/{genre}', [GenreController::class, 'show']);
Route::delete('deletegenre/{genre}', [GenreController::class, 'destroy']);
//Las rutas utilizadas aquí se usan como apis - Creadores
Route::get('getcreators', [CreatorController::class, 'index']);
Route::post('storecreator', [CreatorController::class, 'store']);
Route::put('updatecreator/{creator}', [CreatorController::class, 'update']);
Route::get('creators/{creator}', [CreatorController::class, 'show']);
Route::delete('deletecreator/{creator}', [CreatorController::class, 'destroy']);
//Las rutas utilizadas aquí se usan como apis - Juegos
Route::get('getgames', [CreatorController::class, 'index']);
Route::post('storegame', [CreatorController::class, 'store']);
Route::put('updategame/{game}', [CreatorController::class, 'update']);
Route::get('game/{game}', [CreatorController::class, 'show']);
Route::get('game/{game}/more', [CreatorController::class, 'showName']);
Route::delete('deletegame/{game}', [CreatorController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
