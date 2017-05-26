<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Post;
use App\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\AuthenticationRequest;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(PostRequest $request)
    {
        Post::addPost($request->all());

        \Session::flash('flash_message', '記事を作成しました。');

        return redirect('/');
    }

    public function replyCreate(PostRequest $request)
    {
        Post::addPost($request->all(), $request->input('id'));

        \Session::flash('flash_message', '返信記事を作成しました。');

        return redirect('/');
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
