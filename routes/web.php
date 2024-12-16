<?php

use App\Http\Controllers\CreatorController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlatformController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Las rutas utilizadas aquí se usan como apis - Géneros
    Route::get('/generos', [GenreController::class, 'index'])->name('genres.index');
    Route::get('getgenres', [GenreController::class, 'getAllGenres']);
    Route::get('/generos/create', [GenreController::class, 'create'])->name('genres.create');
    Route::post('storegenre', [GenreController::class, 'store']);
    Route::get('/generos/{genre}/edit', [GenreController::class, 'edit'])->name('genres.edit');
    Route::put('updategenre/{genre}', [GenreController::class, 'update']);
    Route::get('genres/{genre}', [GenreController::class, 'show']);
    Route::delete('deletegenre/{genre}', [GenreController::class, 'destroy']);
    //Las rutas utilizadas aquí se usan como apis - Creadores
    Route::get('/creadores', [CreatorController::class, 'index'])->name('creators.index');
    Route::get('getcreators', [CreatorController::class, 'getAllCreators']);
    Route::get('/creadores/create', [CreatorController::class, 'create'])->name('creators.create');
    Route::post('storecreator', [CreatorController::class, 'store']);
    Route::get('/creadores/{creator}/edit', [CreatorController::class, 'edit'])->name('creators.edit');
    Route::put('updatecreator/{creator}', [CreatorController::class, 'update']);
    Route::get('creators/{creator}', [CreatorController::class, 'show']);
    Route::delete('deletecreator/{creator}', [CreatorController::class, 'destroy']);
    //Las rutas utilizadas aquí se usan como apis - Juegos
    Route::get('/juegos', [GameController::class, 'index'])->name('games.index');
    Route::get('getgames', [GameController::class, 'getAllGames']);
    Route::get('/juegos/create', [GameController::class, 'create'])->name('games.create');
    Route::post('storegame', [GameController::class, 'store']);
    Route::get('/juegos/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('updategame/{game}', [GameController::class, 'update']);
    Route::get('/juegos/{game}/sabermas', [GameController::class, 'more'])->name('games.show');
    Route::get('games/{game}', [GameController::class, 'show']);
    Route::get('games/{game}/more', [GameController::class, 'showName']);
    Route::delete('deletegame/{game}', [GameController::class, 'destroy']);

    Route::get('getplatforms', [PlatformController::class, 'index']);
});

require __DIR__.'/auth.php';