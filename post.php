<?php
session_start();

require "validation.php";
require "include/model/db.php";

$con = db_connect();

// post_idのチェック
if (isset($_REQUEST)) {
    // フォームの入力内容を変数に格納
    $parent_id = null;
    $name = $_POST['name'];
    $form_body = $_POST['form_body'];
    $post_date = date('Y年m月d日 H:i');
    $password = $_POST['password'];

    $check = true;
} else {
    $check = false;
}

if ($check === true) {
    // バリデーションメッセージの格納
    $validate = validation($name, $form_body);
    $_SESSION['result'] = $validate;
} elseif ($check === false) {
    $error_msg[] ='不正なidです。';
    $_SESSION['result'] = $error_msg;
    header("Location: /mybbs/index.php");
    exit();
}

// 投稿をDBへ保存
if ($validate === true) {
    if (isset($_POST['reply_post'])) {
        $parent_id = $_POST['post_id'];
        $stm = $con->prepare("INSERT INTO post(reply_id,name,form_body,post_date,password) values(:reply_id,:name,:form_body,:post_date,:password)");
        $stm->bindValue(':reply_id', $parent_id);

    } elseif(isset($_POST['form_post'])) {
        $stm = $con->prepare("INSERT INTO post(name,form_body,post_date,password) values(:name,:form_body,:post_date,:password)");
    }

    $stm->bindValue(':name', $name);
    $stm->bindValue(':form_body', $form_body);
    $stm->bindValue(':post_date', $post_date);
    $stm->bindValue(':password', $password);

    $result = $stm->execute();

    header("Location: /mybbs/index.php");
    exit();
  // 返信のバリデーションが通らなかった場合
} elseif(isset($_POST['reply_post'])) {
    header("Location: /mybbs/reply.php");
    exit();
  // 新規投稿のバリデーションが通らなかった場合
} elseif(isset($_POST['form_post'])) {
    header("Location: /mybbs/index.php");
    exit();
}
