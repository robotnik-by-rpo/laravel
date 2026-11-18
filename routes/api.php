<?php

use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TrackController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tracks', TrackController::class);
Route::apiResource('artists', ArtistController::class);
Route::post('comments', [CommentController::class, 'store']);
Route::delete('comments/{comment}', [CommentController::class, 'destroy']);