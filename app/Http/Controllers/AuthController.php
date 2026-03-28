<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Crear el usuario en la base de datos
        User::create([
            'name' => $request->name . ' ' . $request->lastname, // Une nombres y apellidos
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encripta la clave como en tu imagen
        ]);

        // 3. Mandarlo al Dashboard que ya diseñamos
        return redirect('/dashboard');
    }
}