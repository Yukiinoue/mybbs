<?php
gd_info();
// エラー表示
ini_set("display_errors", "on");
error_reporting(E_ALL);

// セッション開始
session_start();

// 別ファイルの呼び出し
require 'vendor/autoload.php';
require "include/conf/twig.php";
require "include/model/db.php";


// バリデーションメッセージの受け取り、変数格納
$message = null;

if (isset($_SESSION['result'])) {
    $message = $_SESSION['result'];
    unset($_SESSION['result']);
}

// DB接続
$con = db_connect();

// 画像データの取得
$post_id = null;

// 投稿記事の取得
$reply_id = 0;
$posts = get_post($con, $reply_id);
// header('Content-Type: image/jpeg');

// 返信記事ツリーデータの取得
$tree = get_tree($con, $posts);

// $treeと$messageを$dataにまとめる
$data = array();

$data['tree'] = $tree;
$data['message'] = $message;

// templateの出力
$view = 'index.html';
twig_view ($view, $data);
