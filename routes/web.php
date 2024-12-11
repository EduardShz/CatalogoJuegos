<?php

use Illuminate\Support\Facades\Route;

/*Route::get('gatos', fn() => response()->json([
    'data' => [
        'Lucifer',
        'Garfield',
        'Tom'
    ]
]));
Route::post('gatos', fn() => response()->json([
    'data' => request()->nombre
]));*/


Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');

