<?php


use App\Http\Controllers\ProducteController;
use Illuminate\Support\Facades\Route;

// Inici
Route::get('/', [ProducteController::class, 'index']);

// Registre
Route::get('/register', [ProducteController::class, 'registerGet']);
Route::post('/register', [ProducteController::class, 'registerPost']);

// Lectura de dades
Route::get('/xml', [ProducteController::class, 'xml']);
Route::get('/json', [ProducteController::class, 'json']);
