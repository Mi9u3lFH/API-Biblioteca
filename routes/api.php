<?php

use App\Http\Controllers\Api\LibraryAuthorController;
use App\Http\Controllers\Api\LibraryBookController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::apiResource('authors', LibraryAuthorController::class)->only(['index', 'show']);
Route::apiResource('books', LibraryBookController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('user', fn (Request $request) => $request->user());

    Route::apiResource('authors', LibraryAuthorController::class)->except(['index', 'show']);
    Route::apiResource('books', LibraryBookController::class)->except(['index', 'show']);

    Route::get('export', [ExportController::class, 'export']);
});
