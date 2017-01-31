<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

// セッション開始
session_start();

// 別ファイルの呼び出し
require "include/conf/twig.php";
require "include/model/db.php";

// DB接続
$con = db_connect();

// バリデーションメッセージの受け取り、変数格納
$message = null;

if (isset($_SESSION['result'])) {
    $message = $_SESSION['result'];
    unset($_SESSION['result']);
}

// 投稿一覧を出力
$output = null;

$sth = $con->prepare("SELECT * FROM post WHERE reply_id=0 ORDER BY id DESC");
$sth->execute();
$output = $sth->fetchAll(PDO::FETCH_ASSOC);

// 返信記事の出力
$reply = array();

foreach ($output as $key=>$reply) {
    $id = $reply['id'];
    
    $sth = $con->prepare("SELECT * FROM post WHERE reply_id = :id ORDER BY id ASC");
    $sth->bindValue(':id',$id);
    $sth->execute();

    $output[$key]['children'] = $sth->fetchAll(PDO::FETCH_ASSOC);
}

// templateの出力
$view = 'index.html';
twig_view ($view, $output, $message);
