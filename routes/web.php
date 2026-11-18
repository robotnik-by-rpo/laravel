<?php

use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/music');

Route::resource('music', MusicController::class)
    ->parameters(['music' => 'track']);

Route::post('music/{id}/restore', [MusicController::class, 'restore'])->name('music.restore');
Route::delete('music/{id}/force', [MusicController::class, 'forceDelete'])->name('music.forceDelete');