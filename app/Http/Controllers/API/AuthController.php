<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\S3Service;

class AuthController extends Controller
{
    protected $s3;

    public function __construct()
    {
        $this->s3 = new S3Service();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'password_confirmation' => 'required|same:password',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response([
            'message' => 'User created successfully',
        ]);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('is_admin', false)
            ->first();

        if ($user) {

            if (Auth::attempt($request->only('email', 'password'), $request->remember)) {

                $token = $user->createToken('auth_token')->plainTextToken;

                return response([
                    'message' => 'Login successful',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);

            } else {

                return response([
                    'message' => 'Wrong email or password',
                ], 401);

            }
        } else {
            return response([
                'message' => 'Wrong email or password',
            ], 401);
        }
        ;
    }

    public function atmin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);

        $atmin = User::where('email', $request->email)
            ->where('is_admin', true)
            ->first();

        if ($atmin) {

            if (Auth::attempt($request->only('email', 'password'), $request->remember)) {

                $token = $atmin->createToken('auth_token')->plainTextToken;

                return response([
                    'message' => 'Login successful',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);

            } else {

                return response([
                    'message' => 'Wrong email or password',
                ], 401);

            }
        } else {

            return response([
                'message' => 'Wrong email or password',
            ], 401);

        }

    }

    public function logout(Request $request)
    {

        $request->user()->remember_token = null;
        $request->user()->save();
        $request->user()->tokens()->delete();
        redirect('/');
        return response([
            'message' => 'Logged out successfully',
        ]);

    }

}