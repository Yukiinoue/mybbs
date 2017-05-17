<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controler;
use Carbon\Carbon;

use App\Post;

class BbsController extends Controller
{
	public function index()
	{
		// 最新記事10件の取得
		$post_list = DB::table('posts')->where('posted_at', '<=', Carbon::now())->orderBy('id', 'desc')->paginate(10);
		$post_list->setPath('/');

		return view('index', compact('post_list'));
	}

    public function editPage($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

	public function replyPage($id)
	{
		$post = Post::findOrFail($id);
		return view('posts.reply', compact('post'));
	}
}
