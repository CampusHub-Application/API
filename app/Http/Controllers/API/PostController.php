<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\S3Service;

class PostController extends Controller
{

    protected $s3;

    public function __construct()
    {
        $this->s3 = new S3Service();
    }

    public function posts(Request $request)
    {
        return response([
            'posts' => Post::select('id', 'photo', 'title')->get()
        ]);
    }

    public function post($id)
    {
        try {
            return response([
                'post' => Post::with(['user:id,name,email'])->findOrFail($id)->makeHidden(['user_id', 'created_at', 'updated_at'])
            ]);
        } catch (ModelNotFoundException $e) {
            return response([
                'message' => 'Post tidak ditemukan.'
            ], 404);
        }
    }
    

    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required|image|max:16384',
        ]);

        try {
            $photo = $this->s3->uploadImg('posts', $request->file('photo'));
        } catch (\Exception $errpr) {
            return response([
                'message' => $error->getMessage()
            ], 500);
        }

        Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'photo' => $photo
        ]);

        return response([
            'message' => 'Berhasil Mengunggah Post.'
        ]);
    }
}
