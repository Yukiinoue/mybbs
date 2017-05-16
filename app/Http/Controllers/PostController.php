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
        \Session::flash('flash_message', '記事を作成しました。');

        return redirect('/');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function update($id, PostRequest $request)
    {
        $post = Post::findOrFail($id);

        $post->update($request->all());
        \Session::flash('flash_message', '記事を編集しました。');

        return redirect('/');
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();
        \Session::flash('flash_message', '記事を削除しました。');

        return redirect('/');
    }
}
