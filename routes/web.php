<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('index');

Route::post('/api-token', [ApiTokenController::class, 'store'])->name('api-token.store');
Route::delete('/api-token', [ApiTokenController::class, 'destroy'])->name('api-token.destroy');

