<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

require 'include/conf/twig.php';
require 'include/model/db.php';

// バリデーションメッセージの受け取り、変数格納
$message = null;

if (isset($_SESSION['result'])) {
    $message = $_SESSION['result'];
    unset($_SESSION['result']);
}

// 返信対象の親記事のid取得
$parent_id = $_POST['post_id'];

// 返信対象の親記事の取得
$parent_post = get_parent($con, $parent_id);
var_dump($parent_post);

// templateの出力
$view = 'reply.html';
twig_view($view,$parent_post,$message);
