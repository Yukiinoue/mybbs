<?php

// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

// セッション開始
session_start();

// 別ファイルの呼び出し
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

// 投稿記事の取得
$output = get_post($con);

// templateの出力
$view = 'index.html';
twig_view ($view, $output, $message);
