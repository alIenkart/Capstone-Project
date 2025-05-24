<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackagesController;

Route::middleware('api')->group(function () {
    Route::apiResource('packages', PackagesController::class);
});
