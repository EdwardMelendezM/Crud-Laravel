<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PostController;

Route::resource('/note',NoteController::class);

Route::resource('/post',PostController::class);