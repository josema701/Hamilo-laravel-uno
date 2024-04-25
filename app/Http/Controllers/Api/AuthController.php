<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function iniciarSesion(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        $credenciales = request(["email", "password"]);
        if(!Auth::attempt($credenciales)){
            return response()->json(["mensaje" => "Usuario o contraseña no validos, intente nuevamente"], 401);
        }
        $usuario = $request->user();
        $token = $usuario->createToken('Personal token');
        $tokenResult = $token->plainTextToken;
        return response()->json(["mensaje" => "Usuario logueado correctamente.", "accsess_token" => $tokenResult, "user" => $usuario, "token_type" => "Bearer"], 200);
    }
    public function cerrarSesion()
    {
        Auth::user()->tokens()->delete();
        return response()->json(["mensaje" => "Se ha cerrado la sesion correctamente."]);
    }
}
