<?php
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

$page= empty($_GET["page"]) ? 1 : $_GET["page"];

// DB接続
$con = db_connect();

$count_articles = 10;

// 投稿記事の取得
$posts = get_post($con, 0, $count_articles, $page);
$count_rows = count_rows($con);

// 返信記事ツリーデータの取得
$tree = get_tree($con, $posts);

// $treeと$messageを$dataにまとめる
$data = array();

$data['tree'] = $tree;
$data['message'] = $message;
$data['page'] = paging($count_articles, $count_rows, $page);

// templateの出力
$view = 'index.html';
twig_view ($view, $data);
