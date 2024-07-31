<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'index']);
Route::get('/pet/create', [PageController::class, 'create']);
Route::get('/pet/{id}/edit', [PageController::class, 'edit']);