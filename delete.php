<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

// 別ファイルの呼び出し
require 'vendor/autoload.php';
require 'include/conf/twig.php';
require 'include/model/db.php';

$con = db_connect();


$parent_id = $_POST['post_id'];
$message = null;

// 削除対象記事の取得
$data = array();
$data['parent_post'] = get_parent($con, $parent_id);

// templateの出力
$view = 'delete.html';
twig_view ($view, $data);
