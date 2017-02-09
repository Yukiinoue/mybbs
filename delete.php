<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

require 'include/conf/twig.php';
require 'include/model/db.php';

$con = db_connect();


$parent_id = $_POST['post_id'];
$message = null;

// 削除対象記事の取得
$parent_post = get_parent($con, $parent_id);

// templateの出力
$view = 'delete.html';
twig_view ($view, $parent_post, $message);
