<?php

namespace App\Http\Controllers;

use App\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\AuthenticationRequest;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(PostRequest $request)
    {
        Post::create($request->all());

        return redirect('/');
    }
}
