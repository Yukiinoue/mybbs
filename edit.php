<?php
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

// 編集対象の親記事のid取得
$error_msg = array();

if (isset($_POST['post_id'])) {
    $parent_id = $_POST['post_id'];
} elseif(isset($_SESSION['post_id'])){
    $parent_id = $_SESSION['post_id'];
} elseif(empty($_POST['post_id'])) {
    $error_msg[] = '不正なidです。';
    $_SESSION['result'] = $error_msg;
    header("Location: /mybbs/index.php");
    exit();
}
  
// 編集対象の親記事とバリデーションメッセージの格納
$data = array();

$data['parent_post'] = get_parent($con, $parent_id);
$data['message'] = $message;

if (empty($data['parent_post'])) {
    $error_msg[] = '編集対象記事がありません。';
    $_SESSION['result'] = $error_msg;
    header("Location: /mybbs/index.php");
    exit();
}

// templateの出力
$view = 'edit.html';
twig_view($view,$data);
