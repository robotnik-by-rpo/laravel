<?php

use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;

Route::get('/music/create', [MusicController::class, 'create'])->name('music.create');

Route::post('/music', [MusicController::class, 'store'])->name('music.store');

Route::get('/music', [MusicController::class, 'index'])->name('music.index');
