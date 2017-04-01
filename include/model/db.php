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
    $min = ($pager * 10) - $count_articles;

    // 親記事データを全件取得
    if ($count_articles === null) {
        $sth = $con->prepare("SELECT * FROM post WHERE reply_id = :reply_id ORDER BY id DESC");
    } else {
        $sth = $con->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM post WHERE reply_id = :reply_id ORDER BY id DESC LIMIT :min, :count_articles");
        $sth->bindValue(':count_articles', $count_articles, PDO::PARAM_INT);
        $sth->bindValue(':min', $min, PDO::PARAM_INT);
    }
    $sth->bindValue(':reply_id', $reply_id, PDO::PARAM_STR);

    $sth->execute();
    $posts = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

// ツリー型一覧データの形成
function get_tree($con, $parent_posts)
{
    $tree = array();
    foreach ($parent_posts as $key=>$post)
    {
        $post['form_body'] = getLink($post['form_body']);
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

// 親記事数の取得
function count_rows($con)
{
    // 親記事の全部の件数を取得する
    $sth = $con->prepare("SELECT FOUND_ROWS()");
    $sth->execute();
    return (int)$sth->fetchColumn();
}

// ページング機能
function paging($count_article, $count_rows, $page, $number=5)
{
    // 全ページ数の取得
    $whole_pages = ceil($count_rows / $count_article);

    // 前のページ番号
    $privious = $page - 1;
    // 次のページ番号
    $next = $page + 1;

    // ページ番号
    // 最初のページ番号の設定
    $start = ($page - floor($number/2)) > 0 ? ($page - floor($number/2)) : 1;
    // 最後のページ番号の設定
    $last = ($start > 1) ? ($page + floor($number/2)) : $number;

    // 全ページ数が最後のページ設定よりも少なかった場合の処理
    if($whole_pages < $last )
    {
        $end = $whole_pages;
    } else {
        $end = $last;
    }

    $paging = array();
    if($page != 1)
    {
        $paging[] = "<a href=\"?page=".$privious."\" class=\"previous_button\">前へ</a>";
    }

    // 最初のページのリンク
    for($i = $start; $i<=$end; $i++)
    {
        // 現在ページとその他のページでclassを分ける
        $class = ($page == $i) ? 'class="current"': 'class="page_number"';
        $paging[] = '<a href="?page='.$i.'"'.$class.'>'.$i.'</a>';
    }

    if($page < $whole_pages)
    {
        $paging[] = "<a href=\"?page=".$next."\" class=\"next_button\">次へ</a>";
    }

    return $paging;
}

function getLink($form_body)
{
    // URL抽出の正規表現
    $pattern = '/https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
    // マッチした文字列を処理
    $form_body = preg_replace_callback($pattern, 'replace', htmlspecialchars($form_body));

    return $form_body;
}

function replace($matches)
{
    return '<a href="'.$matches[0].'">'.$matches[0].'</a>';
}