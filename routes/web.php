<?php

use App\Http\Controllers\NovelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NovelController::class, 'index'])->name('home');
Route::get('/novel/{slug}', [NovelController::class, 'show'])->name('novels.show');