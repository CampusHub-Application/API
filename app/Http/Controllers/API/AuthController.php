<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return response([
                'message' => 'Login successful',
            ]);

        } else {

            return response([
                'message' => 'Sorry, invalid email or password',
            ], 401);

        }

    }

    public function logout(Request $request)
    {

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response([
            'message' => 'Logout successful',
        ]);

    }
    
}