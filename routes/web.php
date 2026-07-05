<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieDetailsController;

Route::get('/', [SiteController::class, 'index'])->name('index');

Route::post('/api-token', [ApiTokenController::class, 'store'])->name('api-token.store');
Route::delete('/api-token', [ApiTokenController::class, 'destroy'])->name('api-token.destroy');

Route::post('/search', SearchController::class)->name('search');

Route::get('/search', function () {
    return redirect()->route('index');
});

Route::get('/movies/{imdbId}', MovieDetailsController::class)->name('movies.show');
