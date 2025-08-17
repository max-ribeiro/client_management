<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    public function __construct()
    {
        // Aplica middleware JWT em todas as rotas exceto login
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // Login e gera token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) { // ← use guard 'api'
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // Retorna usuário autenticado
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    // Logout e invalida token
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Refresh do token
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    // Retorna token formatado
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
