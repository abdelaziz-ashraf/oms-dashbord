<?php

use App\Http\Controllers\Api\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return response()->json(['status' => 'ok']);
});

Route::get('/landing-pages/{slug}', [LandingPageController::class, 'show']);