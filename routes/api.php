<?php

use App\Http\Controllers\Api\PayoutController;
use Illuminate\Support\Facades\Route;

Route::post('/payouts', PayoutController::class)
    ->middleware('auth:sanctum')
    ->name('payout.store');
