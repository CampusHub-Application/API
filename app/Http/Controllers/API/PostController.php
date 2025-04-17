<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\S3Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                'post' => Post::with(['user:id,name,email,photo'])->findOrFail($id)->makeHidden(['user_id', 'created_at', 'updated_at'])
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
        } catch (\Exception $error) {
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

    public function mine(Request $request) {

        $id = $request->query('id');
        if ($id) {
            return Post::where('user_id', $id)
            ->select('id', 'photo', 'title')
            ->get();
        } else {
            return Post::where('user_id', $request->user()->id)
            ->select('id', 'photo', 'title')
            ->get();
        }

    }

    public function search(Request $request) {

        $q = $request->query('q');

        return response([
            'posts' => Post::with('user:id,name,photo')
            ->where('title', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%")
            ->orWhereHas('user', function($query) use ($q) {
                $query->where('name', 'like', "%$q%");
            })
            ->select('id', 'title', 'description', 'photo', 'user_id')
            ->get()->makeHidden('user_id')
        ]);
    }
}
