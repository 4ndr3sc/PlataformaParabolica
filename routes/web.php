<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/nosotros', function () {
    return view('nosotros');
});

Route::get('/login', function () { return view('login'); });
Route::get('/register', function () { return view('register'); });
Route::get('/dashboard', function () {
    return view('dashboard');
});



// Esta ruta recibe los datos del formulario
Route::post('/register', [AuthController::class, 'register']);