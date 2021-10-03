<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required",
            "password" => "required",
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'status_code' => 500,
                'message' => 'Unauthorized',
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'token' => $tokenResult
        ]);

    }
}
