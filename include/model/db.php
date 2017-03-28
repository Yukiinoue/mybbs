<?php
// DB接続
function db_connect ()
{
    $con = new PDO('mysql:host=192.168.33.10;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');
    return $con;
}

// 投稿記事一覧の取得
function get_post($con, $reply_id = 0, $count_articles = null, $pager = null)
{
    // 初期化
    $posts = array();

    // 親記事データを全件取得
    if ($count_articles === null) {
        $sth = $con->prepare("SELECT * FROM post WHERE reply_id = :reply_id ORDER BY id DESC");
    } else {
        $sth = $con->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM post WHERE reply_id = :reply_id ORDER BY id DESC LIMIT :count_articles");
        $sth->bindValue(':count_articles', $count_articles, PDO::PARAM_INT);
    }
    $sth->bindValue(':reply_id', $reply_id, PDO::PARAM_STR);

    $sth->execute();
    $posts = $sth->fetchAll(PDO::FETCH_ASSOC);

    if($count_articles) {
        // 親記事の全部の件数を取得する
        $sth = $con->prepare("SELECT FOUND_ROWS()");
        $sth->execute();
        $count_parent = (int)$sth->fetchColumn();

        // 全ページ数の取得
        $whole_pages = ceil($count_parent / $count_articles);
    }

    // $navigation = array();

    // // ページの始点
    // $start_page = 1;
    // // ページの終点
    // $end_page = $whole_pages;
    // // 次ページの取得
    // if($pager < $end_page)
    // {
    //     $next_page = $pager + 1;
    // }
    // // 前ページの取得
    // if($pager > $start_page)
    // {
    //     $previous_page = $pager - 1;
    // }

    // if($pager != 1)
    // {
    //     $navigation[] = '<a href="?page='. $previous_page .'">&laquo; 前へ</a> ';
    // }

    // if($next_page)
    // {
    //     $navigation[] = '<a href="?page='. $next_page .'">次へ&raquo;</a>';
    // }

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

    // $posts['navigation'] = array();
    // $posts['navigation'] = $navigation;
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

    foreach ($id as $key => $parent_id) {

    $sth = $con->prepare("SELECT * FROM file WHERE id = :id");

    $sth->bindValue(':id', $parent_id['id']);
    $sth->execute();
    $file[$key] = $sth->fetch(PDO::FETCH_ASSOC);

    }

    return $file;
}