<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controler;


class BbsController extends Controller
{
	public function index()
	{
		// 最新記事10件の取得
		$post_list = DB::table('posts')->orderBy('id', 'desc')->paginate(10);
		$post_list->setPath('/');

		return view('index', compact('post_list'));
	}
}
