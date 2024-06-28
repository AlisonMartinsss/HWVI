<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tarefa', function () {
    return view('tarefa.index');
})->name('tarefa');

Route::get('/user', function () {
    return view('user.index');
})->name('user');

Auth::routes(['register' => false]);