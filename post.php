<?php
session_start();

require "validation.php";

$con = new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');

// 投稿をDBへ書き込み
if (isset($_POST['form_post']) === true) 
{
  $name = $_POST['name'];
  $form_body = $_POST['form_body'];
  $post_date = date('Y年m月d日 H:i');
  $password = $_POST['password'];
}

$validate = validation($name, $form_body);

$_SESSION['result'] = $validate;


// 投稿をDBへ保存 
if ($validate === true) {
  $stm = $con->prepare("INSERT INTO post(name,form_body,post_date,password) values(:name,:form_body,:post_date,:password)");

  $stm->bindValue(':name', $name);
  $stm->bindValue(':form_body', $form_body);
  $stm->bindValue(':post_date', $post_date);
  $stm->bindValue(':password', $password);
  $result = $stm->execute();
}

header("Location: /mybbs/index.php");
