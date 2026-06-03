<?php

use App\Http\Controllers\Api\LandingPageController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return response()->json(['status' => 'ok']);
});

Route::get('/landing-pages/{slug}', [LandingPageController::class, 'show']);
Route::post('/contact-messages', [ContactMessageController::class, 'store'])->middleware('throttle:10,1');
Route::get('/portfolio', [PortfolioController::class, 'all']);
Route::get('/portfolio/{module}', [PortfolioController::class, 'index']);
