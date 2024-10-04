<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CifradoController;
use App\Http\Controllers\RC6Controller;
use App\Http\Controllers\RabinController;
use App\Http\Controllers\Blake2Controller;

// Ruta principal para la comparación
Route::get('/', [CifradoController::class, 'comparacion']);

// Rutas para los cifrados
Route::get('/cifrado-cesar', [CifradoController::class, 'cesar']);
Route::post('/cifrar', [CifradoController::class, 'cifrar']);
Route::post('/descifrar', [CifradoController::class, 'descifrar']);

Route::get('/cifrado-escitala', [CifradoController::class, 'escitala']);
Route::post('/escitala-cifrar', [CifradoController::class, 'cifrarEscitala']);
Route::post('/escitala-descifrar', [CifradoController::class, 'descifrarEscitala']);


// Rutas para RC6, Rabin y BLAKE2
Route::get('/cifrado-rc6', [RC6Controller::class, 'index']); // Ruta para mostrar el formulario
Route::post('/rc6-cifrar', [RC6Controller::class, 'cifrar']); // Ruta para cifrar
Route::post('/rc6-descifrar', [RC6Controller::class, 'descifrar']); // Ruta para descifrar
// Rutas para el cifrado Rabin
Route::get('/cifrado-rabin', [RabinController::class, 'index']);
Route::match(['get', 'post'], '/rabin-cifrar', [RabinController::class, 'cifrar']);
Route::match(['get', 'post'], '/rabin-descifrar', [RabinController::class, 'descifrar']);



Route::get('/cifrado-blake2', [Blake2Controller::class, 'index']); // Ruta para mostrar la vista
Route::post('/blake2-calculate', [Blake2Controller::class, 'calcularHash']); // Ruta para calcular el hash

