<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

session_start();

// DB接続
require "db.php";
$con = db_connect();

// twig
require 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'debug' => true,
    ));
$twig->addExtension(new Twig_Extension_Debug());

// バリデーションメッセージの受け取り、変数格納
$message = null;

if (isset($_SESSION['result'])) {
    $message = $_SESSION['result'];
    unset($_SESSION['result']);
}

// 投稿一覧を出力
$output = null;

$sth = $con->prepare("SELECT * FROM post WHERE reply_id=0 ORDER BY id DESC");
$sth->execute();
$output = $sth->fetchAll(PDO::FETCH_ASSOC);

// 返信記事の出力
$reply = array();

foreach ($output as &$reply) {
    $id = $reply['id'];

    $sth = $con->prepare("SELECT * FROM post WHERE reply_id = :id ORDER BY id ASC");
    $sth->bindValue(':id',$id);
    $sth->execute();

    $reply['children'] = $sth->fetchAll(PDO::FETCH_ASSOC);
}

unset($reply);


// templateの出力
if (empty($_POST['post_id'])) {
    $template = $twig->load('index.html');
    echo $template->render(['output' => $output, 'message' => $message]);
}
