<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/doctors', [DoctorsController::class, 'index']);
Route::post('/add-doctors', [DoctorsController::class, 'store']);
Route::delete('/delete-doctor/{id}', [DoctorsController::class, 'destroy']);