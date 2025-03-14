<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createUser(StorePostRequest $request)
    {
        // Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|min:6|confirmed'
        // ]);  
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé avec succès',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 201);
    }

    public function loginUser(LoginRequest $request)
{
    // $validated = $request->validated();

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Email ou mot de passe incorrect'
        ], 401);
    }

    $token = $user->createToken("API TOKEN")->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'Connexion réussie',
        'token' => $token
    ], 200);
}
public function logoutUser(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status' => true,
        'message' => 'Déconnexion réussie'
    ], 200);
}
    
}


