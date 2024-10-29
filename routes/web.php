<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/{feed?}/{news?}', [HomeController::class, 'index'])->name('home');
