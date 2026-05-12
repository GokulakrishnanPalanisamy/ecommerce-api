<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User created successfully',
                'access_token' => $token,
                'user_name' => $user->name,
                'email' => $user->email,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Wrong password',
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User logged in successfully',
                'access_token' => $token,
                'user_name' => $user->name,
                'email' => $user->email,
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
