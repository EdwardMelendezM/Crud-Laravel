<?php

use Illuminate\Support\Facades\Route;

// Pasar parametros con url como por ejemplo el id que es opcional
Route::get('/product/{id?}',[Controller::class, 'function'])->name('example');
