<?php

use App\Http\Controllers\Authentication\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::get('/authentication', AuthenticationController::class)->name('authentication');
