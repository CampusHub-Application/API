<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\S3Service;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    protected $s3;

    public function __construct()
    {
        $this->s3 = new S3Service();
    }

    public function profile(Request $request)
    {
        return response([
            Auth::user()->makeHidden(['created_at', 'updated_at']),
        ]);
    }
    

}