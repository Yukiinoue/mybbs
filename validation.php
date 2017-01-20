<?php
session_start();

// フォームのバリデーション
function validation($name, $form_body) 
{
  $result = true;
  if ($name == '') {
    $result = false;
    $error_msg[] = '名前が入力されていません。';
  }

  if ($form_body == '') {
    $result = false;
    $error_msg[] = '本文が入力されていません。';
  }

  if ($result == true) {
    return $_SESSION['result'] = $result;
  } elseif ($result == false) {
    return $_SESSION['error_msg'] = $error_msg;
  }
}
