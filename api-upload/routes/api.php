<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\RecordController;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::post('/oauth/token',     [AccessTokenController::class, 'issueToken'])->middleware('throttle');
Route::post('/register',        [AuthController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function () {
    
    Route::prefix('uploads')->group(function () {
        Route::post('/', [UploadController::class, 'store']);
        Route::get('/',  [UploadController::class, 'history']);
    });

    Route::prefix('records')->group(function () {
        Route::get('/',  [RecordController::class, 'search']);
    });
});
