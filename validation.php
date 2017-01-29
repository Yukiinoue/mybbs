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
