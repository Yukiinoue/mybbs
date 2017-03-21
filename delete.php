<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

session_start();

// 別ファイルの呼び出し
require 'vendor/autoload.php';
require 'include/conf/twig.php';
require 'include/model/db.php';

// DB接続
$con = db_connect();

// バリデーションメッセージの受け取り、変数格納
$message = null;

if (isset($_SESSION['result'])) {
    $message = $_SESSION['result'];
    unset($_SESSION['result']);
}

// 削除対象の親記事のid取得
$error_msg = array();

$parent_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : null;
if (! $parent_id) {
    die('post_idがありません。');
}

// 削除対象の親記事とバリデーションメッセージの格納
$data = array();

$data['parent_post'] = get_parent($con, $parent_id);
$data['file'] = get_file($con, $parent_id);
$data['message'] = $message;

if (! $data['parent_post']) {
    die('削除対象記事がありません。');
}

// templateの出力
$view = 'delete.html';
twig_view ($view, $data);
