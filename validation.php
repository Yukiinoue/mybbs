<?php
// フォームのバリデーション
function validation($name, $form_body)
{
    $result = true;
    $error_msg = [];

    if ($name == '') {
        $result = false;
        $error_msg[] = '名前が入力されていません。';
    }

    if ($form_body == '') {
        $result = false;
        $error_msg[] = '本文が入力されていません。';
    }

    if ($result == true) {
        return $result;
    } elseif ($result == false) {
        return $error_msg;
    }
}

// 編集フォームのバリデーション
// 後に、validation関数と統合できたら統合
function edit_validation($form_body, $password)
{
    $result = true;
    $error_msg = [];

    if($password == '') {
        $result = false;
        $error_msg[] = 'パスワードが入力されていません。';
    }

    if ($form_body == '') {
        $result = false;
        $error_msg[] = '本文が入力されていません。';
    }

    if($result == true) {
        return $result;
    } elseif ($result == false) {
        return $error_msg;
    }
}

// 削除フォームのバリデーション
function delete_validation($password)
{
    $result = true;
    $error_msg = [];

    if($password == '') {
        $result = false;
        $error_msg[] = 'パスワードが入力されていません。';
    }

    if($result == true) {
        return $result;
    } elseif ($result == false) {
        return $error_msg;
    }
}
