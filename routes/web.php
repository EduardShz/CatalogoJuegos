<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('api/login', [LoginController::class, 'login']);
Route::post('api/logout', [LoginController::class, 'logout']);
Route::post('api/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('api/user', [RegisteredUserController::class, 'show']);
    Route::get('api/user/roles', function (Request $request) {
        // Devuelve los roles del usuario autenticado
        return response()->json([
            'roles' => $request->user()->getRoleNames(), // Método de Spatie para obtener roles
        ]);
    });
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Las rutas utilizadas aquí se usan como apis - Géneros
    Route::get('api/genres', [GenreController::class, 'index']);
    Route::post('api/genres/store', [GenreController::class, 'store']);
    Route::put('api/genres/{genre}', [GenreController::class, 'update']);
    Route::get('api/genres/{genre}', [GenreController::class, 'show']);
    Route::delete('api/genres/{genre}', [GenreController::class, 'destroy']);

    //Las rutas utilizadas aquí se usan como apis - Creadores
    Route::get('api/creators', [CreatorController::class, 'index']);
    Route::post('api/creators/store', [CreatorController::class, 'store']);
    Route::put('api/creators/{creator}', [CreatorController::class, 'update']);
    Route::get('api/creators/{creator}', [CreatorController::class, 'show']);
    Route::delete('api/creators/{creator}', [CreatorController::class, 'destroy']);

    //Las rutas utilizadas aquí se usan como apis - Juegos
    Route::get('api/games', [GameController::class, 'index']);
    Route::post('api/games/store', [GameController::class, 'store']);
    Route::put('api/games/{game}', [GameController::class, 'update']);
    Route::get('api/games/{game}/showI', [GameController::class, 'showId']);
    Route::get('api/games/{game}/showN', [GameController::class, 'showName']);
    Route::delete('api/games/{game}', [GameController::class, 'destroy']);

    Route::get('api/platforms', [PlatformController::class, 'index']);

    Route::get('api/games/{game}/comments', [CommentController::class, 'index']);
    Route::post('api/games/{game}/comments', [CommentController::class, 'store']);
    Route::delete('api/games/{game}/comments/{comment}', [CommentController::class, 'destroy']);
});


Route::get('/{any}', fn() => view('app'))->where('any', '.*');

// require __DIR__.'/auth.php';