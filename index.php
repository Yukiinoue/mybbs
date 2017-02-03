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


// 投稿記事の取得

function get_post($con, $reply_id = 0)
{
// 初期化
$output = array();

// 一覧データの取得
$sth = $con->prepare("SELECT * FROM post WHERE reply_id = :reply_id ORDER BY id DESC");
$sth->bindValue(':reply_id', $reply_id);
$sth->execute();
$output = $sth->fetchAll(PDO::FETCH_ASSOC);

return $output;
}

$output = get_post($con);

// ツリー型一覧データの形成
function get_tree($con, $parent_posts)
{
    $post = array();
    foreach ($parent_posts as $key=>$post)
    {
        // 親記事に対する返信一覧を取得し、childrenへ挿入
        $post[$key]['children'] = get_post($con, $post['id']);

        // 取得したchildrenを親とした返信一覧の取得し、ループ
        $post[$key]['children'] = get_tree($con, $post[$key]['children']);
    }

    // ツリー型一覧データの返却
    return $post;
}

$reply = get_tree($con, $output);
var_dump($reply);


// templateの出力
$view = 'index.html';
twig_view ($view, $output, $message);
