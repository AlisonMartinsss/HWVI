<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('tarefa', 'App\Http\Controllers\TarefaController');
Route::apiResource('user', 'App\Http\Controllers\UserController');