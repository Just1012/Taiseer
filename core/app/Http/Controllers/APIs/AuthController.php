<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 400,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }
        $validatedData = $validator->valid();
        $user = User::where('email','=', $validatedData['email'])->first();
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return [
                'status' => 401,
                'message' => 'Invalid credentials'
            ];
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'data' => $user

        ]);

    }
}
