<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

// twig
require 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);


session_start();

$con = new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');

$message = null;

if (isset($_SESSION['result'])) {
  $message = $_SESSION['result'];
  unset($_SESSION['result']);
}

// function pagination()
// {
//   $page_num = $con->prepare("SELECT COUNT(*) id FROM post")
// }

// $msg = message($validate);
  
// 投稿一覧を出力
$sth = $con->prepare("SELECT * FROM post ORDER BY id DESC");

$sth->execute();

$output = $sth->fetchAll(PDO::FETCH_ASSOC);

$template = $twig->load('index.html');
echo $template->render(['output' => $output, 'message' => $message]);
