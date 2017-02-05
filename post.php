<?php
session_start();

require "validation.php";
require "include/model/db.php";

$con = db_connect();

// フォームの入力内容を変数に格納
$parent_id = null;
$name = $_POST['name'];
$form_body = $_POST['form_body'];
$post_date = date('Y年m月d日 H:i');
$password = $_POST['password'];

if (isset($_POST['parent_id'])) {
    $parent_id = $_POST['parent_id'];
}


// バリデーションメッセージの格納
$validate = validation($name, $form_body);
$_SESSION['result'] = $validate;


// 投稿をDBへ保存
if ($validate === true) {
    if ($parent_id) {
        $stm = $con->prepare("INSERT INTO post(reply_id,name,form_body,post_date,password) values(:reply_id,:name,:form_body,:post_date,:password)");
        $stm->bindValue(':reply_id', $parent_id);
    } else {
        $stm = $con->prepare("INSERT INTO post(name,form_body,post_date,password) values(:name,:form_body,:post_date,:password)");
    }

    $stm->bindValue(':name', $name);
    $stm->bindValue(':form_body', $form_body);
    $stm->bindValue(':post_date', $post_date);
    $stm->bindValue(':password', $password);

    $result = $stm->execute();
}

header("Location: /mybbs/index.php");
