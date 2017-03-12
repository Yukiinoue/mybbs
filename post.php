<?php
// エラー表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

session_start();

// 依存ライブラリのロード
require "validation.php";
require "include/model/db.php";

// DB接続
$con = db_connect();


$parent_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;

// 返信の場合のチェック
if ($parent_id) {
    // 記事の有無をチェック
    $post = get_parent($con, $parent_id);
    if (! $post) {
        die('記事がありません。');
    }
}

// 名前の有無をチェック
$name = isset($_POST['name']) ? $_POST['name'] : null;
// 本文の有無をチェック
$form_body = isset($_POST['form_body']) ? $_POST['form_body'] : null;
// パスワードの有無をチェック
$password = isset($_POST['password']) ? $_POST['password'] : null;
$post_date = date('Y年m月d日 H:i');
// アップロードファイルの有無をチェック
$file = isset($_FILES['upload']) ? $_FILES['upload'] : null;
// 文字列を読み込む
$get_file = base64_encode(file_get_contents($file['tmp_name']));

// バリデーションメッセージの格納
$validate = validation($name, $form_body);
$_SESSION['result'] = $validate;

// バリデーションが通らなかった時の画面の遷移
if($validate !== true) {
    if ($parent_id) {
        // 返信時の遷移
        header("Location: reply.php?post_id=$parent_id");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

// 投稿をDBへ保存
if ($parent_id) {
    $stm = $con->prepare("INSERT INTO post(reply_id,name,form_body,post_date,password) values(:reply_id,:name,:form_body,:post_date,:password)");
    $stm->bindValue(':reply_id', $parent_id);
} else {
    $stm = $con->prepare("INSERT INTO post(name,form_body,post_date,password) values(:name,:form_body,:post_date,:password)");
}

$stm->bindValue(':name', $name);
$stm->bindValue(':form_body', $form_body);
$stm->bindValue(':post_date', $post_date);
$stm->bindValue(':password', $password);

$result = $stm->execute();

// アップロード画像が存在すれば、DBへ保存
if($file) {
    if ($parent_id === null) {
        $parent_id = get_latest_post_id($con);
    }
    $stm = $con->prepare("INSERT INTO file(post_id,file_name,type,contents) values(:parent_id,:file_name,:type,:contents)");

    $stm->bindValue(':parent_id', $parent_id);
    $stm->bindValue(':file_name', $file['name']);
    $stm->bindValue(':type', $file['type']);
    $stm->bindValue(':contents', $get_file);

    $result_upload = $stm->execute();
}

header("Location: index.php");
exit();
