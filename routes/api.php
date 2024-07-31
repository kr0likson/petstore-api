<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pets', [PetApiController::class, 'index']);
Route::post('/pets', [PetApiController::class, 'store']);
Route::get('/pets/{id}', [PetApiController::class, 'show']);
Route::put('/pets/{id}', [PetApiController::class, 'update']);
Route::delete('/pets/{id}', [PetApiController::class, 'destroy']);