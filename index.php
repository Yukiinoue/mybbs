<?php
// エラー表示
ini_set("display_errors", "On");
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
$files = get_files($con);

// 投稿記事の取得
$posts = get_post($con);

// header('Content-type: image/jpeg');

// 返信記事ツリーデータの取得
$tree = get_tree($con, $posts);
// $treeと$messageを$dataにまとめる
$data = array();

$data['tree'] = $tree;
$data['message'] = $message;

// templateの出力
$view = 'index.html';
twig_view ($view, $data);
