<?php

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])->middleware('throttle');
