<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/', [HomeController::class, 'index'])->name('home');
