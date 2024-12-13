<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //Log::info('Datos recibidos:', $request->all()); --> Log Para comprobar los datos del usuario que intenta accesar a la plataforma

        // Recibir los datos mandados por el login
        $credentials = $request->only('email', 'password');

        // Intento de la autenticación de Laravel con los datos pasados
        if (Auth::attempt($credentials)) {
            // Regenerar la sesión para evitar secuestros de sesión
            $request->session()->regenerate();

            //Log::info('Autenticación exitosa para el usuario:', ['email' => $credentials['email']]);

            // Retornar respuesta de éxito
            return response()->json(['message' => 'Login successful'], 200);
        }

        //Log::warning('Fallo en la autenticación para el usuario:', ['email' => $credentials['email'],'password' => $credentials['password']]);
        
        // Si no se puede autenticar, se devuelve un mensaje de error
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
