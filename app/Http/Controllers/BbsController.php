<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BbsController extends Controller
{
	public function index()
	{
		$posts = Post::all();

		return view('index', compact('posts'));
	}
}
