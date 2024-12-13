<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

// Rutas protegidas con autenticación
Route::middleware('auth')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::post('loginusers', [AuthController::class, 'login']);
Route::post('logoutusers', [AuthController::class, 'logout']);

//Las rutas utilizadas aquí se usan como apis
Route::get('getgenres', [GenreController::class, 'index']);
Route::post('storegenre', [GenreController::class, 'store']);
Route::put('updategenre/{id}', [GenreController::class, 'update']);
Route::get('genres/{id}', [GenreController::class, 'show']);
Route::delete('deletegenre/{id}', [GenreController::class, 'destroy']);

//Auth::routes();
Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');
