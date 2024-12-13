<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Models\User;
use Illuminate\Http\Request;

/*Route::get('gatos', fn() => response()->json([
    'data' => [
        'Lucifer',
        'Garfield',
        'Tom'
    ]
]));*/

// Rutas protegidas con autenticación
Route::middleware('auth')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::post('loginusers', [AuthController::class, 'login']);
Route::post('logoutusers', [AuthController::class, 'logout']);

//Auth::routes();
Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');
