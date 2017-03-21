<?php
// DB接続
function db_connect ()
{
    $con = new PDO('mysql:host=192.168.33.10;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');
    return $con;
}

// 投稿記事一覧の取得
function get_post($con, $reply_id = 0)
{
    // 初期化
    $posts = array();


    // 親記事データを全件取得
    $sth = $con->prepare("SELECT * FROM post WHERE reply_id = :reply_id ORDER BY id DESC");
    $sth->bindValue(':reply_id', $reply_id);
    $sth->execute();
    $posts = $sth->fetchAll(PDO::FETCH_ASSOC);


    foreach ($posts as $key => $post) {
        // 画像データを全件取得
        $sth = $con->prepare("SELECT * FROM file WHERE `post_id` = :post_id");
        $sth->bindValue(':post_id', $post['id']);
        $sth->execute();
        $files_data = $sth->fetchAll(PDO::FETCH_ASSOC);

        $posts[$key]['files'] = array_map(function($file){
            $file['contents']= base64_encode($file['contents']);
            return $file;
        }, $files_data);

    }

    return $posts;
}

// ツリー型一覧データの形成
function get_tree($con, $parent_posts)
{
    $tree = array();
    foreach ($parent_posts as $key=>$post)
    {
        // 親記事に対する返信一覧を取得
        $posts = get_post($con, $post['id']);
        // 親記事自体を格納
        $tree[$key] = $post;

        // 取得したchildrenを親とした返信一覧の取得し、ループ
        $tree[$key]['children'] = get_tree($con, $posts);

    }
    // ツリー型一覧データの返却
    return $tree;
}

// 返信用の対象親記事の取得（単一記事）
function get_parent($con, $parent_id)
{
    // 配列の初期化
    $parent_post = array();
    $sth = $con->prepare("SELECT * FROM post WHERE id = :parent_id");

    $sth->bindValue(':parent_id', $parent_id);
    $sth->execute();

    $parent_post = $sth->fetch(PDO::FETCH_ASSOC);

    return $parent_post;
}

// 削除処理
function delete_post ($con, $parent_id)
{
    $sth = $con->prepare("DELETE FROM post WHERE id=:id");

    $sth->bindValue(':id', $id);
    $sth->execute();
}

// 新規投稿時に割り振られた記事idの取得
function get_latest_post_id ($con)
{
    $sth = $con->prepare("SELECT `id` FROM post ORDER BY `id` DESC LIMIT 1");

    $sth->execute();
    $id = $sth->fetch(PDO::FETCH_ASSOC);
    return $id['id'];
}

// 投稿された画像の取得（単一の画像）
function get_file($con, $post_id)
{

    $stm = $con->prepare("SELECT `id` FROM file WHERE post_id = :post_id" );

    $stm->bindValue(':post_id', $post_id);
    $stm->execute();

    $id = $stm->fetchAll(PDO::FETCH_ASSOC);

    foreach ($parents_id as $key => $parent_id) {

    $sth = $con->prepare("SELECT * FROM file WHERE id = :id");

    $sth->bindValue(':id', $id['id']);
    $sth->execute();
    $file[$key] = $sth->fetch(PDO::FETCH_ASSOC);

    }

    return $file;
}
