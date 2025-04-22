<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|exists:users,email',
                'password' => 'required|string'
            ]);
            if ($validateUser->fails()) {
                return response()->json(['success' => false, 'errors' => $validateUser->errors()], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json(['success' => false, 'errors' => ['email' => ['These credentials do not match our records']]], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'success' => true,
                'token' => $user->createToken('authToken')->plainTextToken,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'name' => 'required|string'
        ]);
        if ($validateUser->fails()) {
            return response()->json(['success' => false, 'errors    ' => $validateUser->errors()], 401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['success' => true, 'token' => $user->createToken('authToken')->plainTextToken], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['success' => true], 200);
    }
}
