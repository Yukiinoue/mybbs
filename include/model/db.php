<?php
// DB接続
function db_connect ()
{
    $con = new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');
    return $con;
}

// DB接続
$con = db_connect();

// 投稿記事の取得
function get_post($con, $reply_id = 0)
{
// 初期化
$output = array();

// 一覧データの取得
$sth = $con->prepare("SELECT * FROM post WHERE reply_id = :reply_id ORDER BY id DESC");
$sth->bindValue(':reply_id', $reply_id);
$sth->execute();
$output = $sth->fetchAll(PDO::FETCH_ASSOC);

return $output;
}

$output = get_post($con);

// ツリー型一覧データの形成
function get_tree($con, $parent_posts)
{
    $post = array();
    foreach ($parent_posts as $key=>$post)
    {

        // 親記事に対する返信一覧を取得
        $posts = get_post($con, $post['id']);

        // 取得したchildrenを親とした返信一覧の取得し、ループ
        $post[$key]['children'] = get_tree($con, $posts);
    }

    // ツリー型一覧データの返却
    return $post;
}


$reply = get_tree($con, $output);
