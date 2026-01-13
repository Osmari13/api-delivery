<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserGlobalRole;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //Para abrir la ducumentacion de la API http://127.0.0.1:8000/docs/api
    /**
     * register.admin
     * @unauthenticated
     */
    public function register(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'name'     => 'required|string|max:255',
                'username' => 'required|string|max:150',
                'email'    => 'required|string|email|max:255',
                'phone'    => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'role'     => 'required|string|in:CLIENT,SYSTEM_ADMIN',
            ]);
            // 1️⃣ Crear usuario global
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // 2️⃣ Registrar role global
            UserGlobalRole::create([
                'user'    => $user->username,
                'role'       => $request->role,
                'created_at' => now(),
            ]);

            // 4️⃣ Crear token Sanctum
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user'  => $user,
                'token' => $token
            ], 201);
        });
    }

    /**
     * login
     * @unauthenticated
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            abort(401);
        }
        
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();
    //     return response()->json(['message' => 'Logout exitoso']);
    // }
}
