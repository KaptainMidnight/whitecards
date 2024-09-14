<?php

declare(strict_types=1);


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('profile', ProfileController::class);
