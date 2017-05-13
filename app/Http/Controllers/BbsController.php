<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controler;


class BbsController extends Controller
{
	public function index()
	{
		// 最新記事10件の取得
		$posts = DB::table('posts')->orderBy('id', 'desc')->take(10)->get();

		return view('index', compact('posts'));
	}
}
