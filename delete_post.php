<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

session_start();

// 依存ライブラリのロード
require 'vendor/autoload.php';
require "validation.php";
require "include/model/db.php";

// DB接続
$con = db_connect();

// post_idのチェック
$parent_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
if (! $parent_id) {
    die('post_idがありません。');
}

// 記事の有無をチェック
$post = get_parent($con, $parent_id);
if (! $post) {
    die('記事がありません。');
}

// パスワードの有無をチェック
$password = isset($_POST['password']) ? $_POST['password'] : null;

// ファイルidの有無をチェック
$file_id = isset($_POST['file_id']) ? $_POST['file_id'] : null;

// バリデーションメッセージの格納
$validate = delete_validation($password);
$_SESSION['result'] = $validate;

// バリデーションが通らなかった時の画面の遷移
if ($validate !== true) {
    header("Location: delete.php?post_id=$parent_id");
    exit();
}

// エラーメッセージの表示
if ($password !== $post['password']) {
    $error_msg[] = 'パスワードが間違っています。';
    $_SESSION['result'] = $error_msg;
    header("Location: delete.php?post_id=$parent_id");
    exit();
}
// 削除処理
$stm = $con->prepare("DELETE FROM post WHERE password = :password AND id = :id");
$stm->bindValue(':password', $password);
$stm->bindValue(':id', $parent_id);

$stm->execute();

// header("Location: index.php");
// exit();
