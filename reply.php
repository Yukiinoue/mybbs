<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

require 'include/conf/twig.php';

// バリデーションメッセージの受け取り、変数格納
$message = null;

if (isset($_SESSION['result'])) {
    $message = $_SESSION['result'];
    unset($_SESSION['result']);
}

// templateの出力
$parent_id = $_POST['post_id'];
$view = 'reply.html';
twig_view ($twig, $view, $parent_id, $message);