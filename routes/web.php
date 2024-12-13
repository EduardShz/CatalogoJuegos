<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreatorController;
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

//Las rutas utilizadas aquí se usan como apis - Géneros
Route::get('getgenres', [GenreController::class, 'index']);
Route::post('storegenre', [GenreController::class, 'store']);
Route::put('updategenre/{id}', [GenreController::class, 'update']);
Route::get('genres/{id}', [GenreController::class, 'show']);
Route::delete('deletegenre/{id}', [GenreController::class, 'destroy']);

//Las rutas utilizadas aquí se usan como apis - Creadores
Route::get('getcreators', [CreatorController::class, 'index']);
Route::post('storecreator', [CreatorController::class, 'store']);
Route::put('updatecreator/{id}', [CreatorController::class, 'update']);
Route::get('creators/{id}', [CreatorController::class, 'show']);
Route::delete('deletecreator/{id}', [CreatorController::class, 'destroy']);

//Auth::routes();
Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');
