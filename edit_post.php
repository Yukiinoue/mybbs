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
if (! $_POST['post_id']) {
    die('post_idがありません。');
}

// 記事の有無をチェック
$post = get_parent($con, $parent_id);
if (! $post) {
    die('記事がありません。');
}
// 本文の有無をチェック
$parent_id = isset($_POST['form_body']) ? $_POST['form_body'] : null;
if (! $_POST['form_body']) {
    die('form_bodyがありません。');
}
// パスワードの有無をチェック
$parent_id = isset($_POST['password']) ? $_POST['password'] : null;
if (! $_POST['password']) {
    die('passwordがありません。');
}


// フォームの入力内容を変数に格納
$form_body = $_POST['form_body'];
$post_date = date('Y年m月d日 H:i');
$password = $_POST['password'];

// バリデーションメッセージの格納
$validate = edit_validation($form_body, $password);
$_SESSION['result'] = $validate;

// 編集対象記事のパスワードを取得
if ($validate === true) {
    $parent_password = array();
    $sth = $con->prepare("SELECT password FROM post WHERE id = :id");
    $sth->bindValue('id', $parent_id);

    $sth->execute();

    $parent_password = $sth->fetch(PDO::FETCH_ASSOC);
    $parent_password = $parent_password['password'];

} else {
    // バリデーションが通らなかった時の画面の遷移
    header("Location: /mybbs/edit.php");
    exit();
}

// 更新処理
if ($password == $parent_password) {
    // 記事本文の更新
    $stm = $con->prepare("UPDATE post SET form_body=:form_body WHERE id = :id");
    $stm->bindValue(':form_body', $form_body);
    $stm->bindValue(':id', $parent_id);

    $stm->execute();

    header("Location: /mybbs/index.php");
    exit();
} else {
    // エラーメッセージの表示
    $error_msg[] = 'パスワードが間違っています。';
    $_SESSION['result'] = $error_msg;
    $_SESSION['post_id'] = $parent_id;
    header("Location: /mybbs/edit.php");
    exit();
}
