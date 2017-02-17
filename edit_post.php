<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

session_start();

// 別ファイルの呼び出し
require 'vendor/autoload.php';
require "validation.php";
require "include/model/db.php";

$con = db_connect();

// フォームの入力内容を変数に格納
$parent_id = $_POST['post_id'];
$form_body = $_POST['form_body'];
$post_date = date('Y年m月d日 H:i');
$password = $_POST['password'];


// バリデーションメッセージの格納
$validate = edit_validation($form_body, $password);
$_SESSION['result'] = $validate;


// 編集対象記事のパスワードを取得
if ($validate === true) {
    if (isset($_POST['post_id'])) {
        $parent_password = array();
        $sth = $con->prepare("SELECT password FROM post WHERE id = :id");
        $sth->bindValue('id', $parent_id);

        $sth->execute();

        $parent_password = $sth->fetch(PDO::FETCH_ASSOC);
        $parent_password = $parent_password['password'];

    }
} elseif(empty($_POST['post_id'])) {
    $error_msg[] = '不正なidです。';
    $_SESSION['result'] = $error_msg;
    header("Location: /mybbs/index.php");
} else {
    header("Location: /mybbs/edit.php");
    exit();
}

// パスワードが一致しているかどうかの判定
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
