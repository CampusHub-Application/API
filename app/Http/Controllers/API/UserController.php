<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\S3Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{

    protected $s3;

    public function __construct()
    {
        $this->s3 = new S3Service();
    }

    public function profile(Request $request)
    {
        return response([
            'profile' => Auth::user()
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

    public function user(Request $request, $id)
    {
        try {
            return response([
                'user' => User::findOrFail($id)
            ]);
        } catch (ModelNotFoundException $e) {
            return response([
                'message' => 'User tidak ditemukan.'
            ], 404);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'is_admin' => 'required|boolean',
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
            'is_admin' => $request->is_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => $photo,
        ]);

        return response([
            'message' => 'User created successfully',
        ]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'required_with:password|same:password',
            'photo' => 'nullable|image|max:16384',
        ]);        

        try {
            $user = User::findOrFail($request->id);
        } catch (ModelNotFoundException $e) {
            return response([
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

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

    public function delete(Request $request)
    {

        try {
            $user = User::findOrFail($request->id);
        } catch (ModelNotFoundException $e) {
            return response([
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        if ($user->photo) {
            try {
                $this->s3->deleteImg('users', $user->photo);
            } catch (\Exception $error) {
                return response([
                    'message' => $error->getMessage()
                ], 500);
            }
        }

        $user->delete();

        return response([
            'message' => 'User deleted successfully',
        ]);

    }

}