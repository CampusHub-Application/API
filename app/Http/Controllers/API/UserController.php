<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\S3Service;

class UserController extends Controller
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
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'photo' => 'nullable|image|max:16384',
        ]);

        $photo = null;
        if ($request->hasFile('photo')) {

            try {
                $photo = $this->s3->uploadImg('users', $request->file('photo'));
            } catch (\Exception $error) {
                return response([
                    'message' => $error->getMessage()
                ], 500);
            }

        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => $photo,
        ]);

        return response([
            'message' => 'User created successfully',
        ]);

    }

    public function users(Request $request)
    {
        return response([
            'admin' => User::where('is_admin', true)->count(),
            'non_admin' => User::where('is_admin', false)->count(),
            'users' => User::all()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'required_with:password|same:password',
            'photo' => 'nullable|image|max:16384',
        ]);        

        $user = User::findOrFail($request->id);
        if ($request->hasFile('photo')) {

            try {
                $photo = $this->s3->uploadImg('users', $request->file('photo'), basename($user->photo));

                if (!$user->photo) {
                    $user->update([
                        'photo' => $photo,
                    ]);
                }

            } catch (\Exception $error) {
                return response([
                    'message' => $error->getMessage()
                ], 500);
            }

        }

        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response([
            'message' => 'User updated successfully',
        ]);

    }
    
}