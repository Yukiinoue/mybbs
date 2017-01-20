<?php
ini_set("display_errors", "On");//エラー表示ON
error_reporting(E_ALL);

session_start();

$con = new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');


// function pagination()
// {
//   $page_num = $con->prepare("SELECT COUNT(*) id FROM post")
// }

// $msg = message($validate);
  
// 投稿一覧を出力
$sth = $con->prepare("SELECT * FROM post ORDER BY id DESC");

$sth->execute();

$output = $sth->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>井上のBBS</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
  </head>
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <!-- <script src="js/reply.js"></script> -->
    <div id="all">
      <div class="row wrapper">
        <h1 id="form-ttl">井上のBBS</h1>
        <div class="form-wrap">
          <form action="post.php" method="post" accept-charset="utf-8">
            <h2 class="sub-ttl">投稿フォーム</h2>
            <?php 
            if ($_SESSION['result'] === true) {
              echo '<span class="suc-msg">投稿を送信しました。</span>';
            } else if(isset($_SESSION['result'])) {
              foreach ($_SESSION['result'] as $value) {
              echo '<span class="err-msg">'.$value.'</span><br>';  
              }
            }
            ?>
              <div class="text-box form-group">
                <span class="form-item">名前</span>
                <input class="form-text form-control" type="text" name="name"><br>
              </div>  
              <div class="text-box form-group">
                <span class="form-item">本文</span><br>
                <textarea class="form-body" name="form_body" cols="68" rows="10"></textarea><br>
                <span class="post-btn">
                  <input class="form-text" type="submit" name="form_post" value="投稿">
                </span>
              </div>
          </form>  
        </div>
        <h2 class="sub-ttl">投稿一覧</h2>      
        <?php 
          for ($i=0; $i < count($output); $i++) { 
          echo '<div class="post-list"><span id="'.$output[$i]['id'].'"class="post-number">No:'.$output[$i]['id'].'<br><span class="post-name">名前:'.$output[$i]['name'].'</span><span class="post-date">'.$output[$i]['post_date'].'</span><br><p class="post-body">'.$output[$i]['form_body'].'</p><br><a href="reply.php"><span class="reply">返信する</span></a></div><form action="delete.php" method="post"><input type="hidden" name="post_id" value="'.$output[$i]['id'].'"><button class="delete-btn"type="submit" name="delete_btn">削除</button></form>';
          }
        ?>
        <div class="form-wrap">
          <form action="post.php" method="post" accept-charset="utf-8">
            <h2 class="sub-ttl">投稿フォーム</h2>
              <div class="text-box form-group">
                <span class="form-item">名前</span>
                <input class="form-text form-control" type="text" name="name"><br>
              </div>  
              <div class="text-box form-group">
                <span class="form-item">本文</span><br>
                <textarea class="form-body" name="form_body" cols="68" rows="10"></textarea><br>
                <span class="post-btn">
                  <input class="form-text" type="submit" name="form_post" value="投稿">
                </span>
              </div>
          </form>  
        </div>
      </div>
    </div>
  </body>
</html>
<?php
session_destroy();
?>
          <!-- 返信ボタン
              <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#sampleModal" data-recipient="受信者名">
              返信する
              </button>
           -->
          <!-- モーダル・ダイアログ
              <div class="modal" id="sampleModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                      <h4 class="modal-title">返信</h4>
                    </div>
                    <div class="modal-body">
                      メッセージ：<input type="text">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                      <button type="button" class="btn btn-primary">ボタン</button>
                    </div>
                  </div>
                </div>
              </div>
          -->