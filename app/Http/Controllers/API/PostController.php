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
        $post = Post::with(['user:id,name,email'])->findOrFail($id)->makeHidden(['user_id', 'created_at', 'updated_at']);
    
        return response([
            'post' => $post
        ]);
    }
    

    public function create(Request $request)
    {
        // Logic to create a new post
    }
}
