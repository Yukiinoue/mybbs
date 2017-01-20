<?php

require "validation.php";
// 投稿をDBへ書き込み
if (isset($_POST['form_post']) === true) 
{
  $name = $_POST['name'];
  $form_body = $_POST['form_body'];
  $post_date = date('Y年m月d日 H:i');
}

$validate = validation($name, $form_body);
// 投稿をDBへ保存 
if ($validate === true) {
  $stm = $con->prepare("INSERT INTO post(name,form_body,post_date) values(:name,:form_body,:post_date)");

  $stm->bindValue(':name', $name);
  $stm->bindValue(':form_body', $form_body);
  $stm->bindValue(':post_date', $post_date);
  $result = $stm->execute();
}