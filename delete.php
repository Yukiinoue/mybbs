<?php
$con = new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');

// 削除機能
if (isset($_POST['post_id'])) {
  $id = $_POST['post_id'];
} else {
  echo "エラーが発生しました。";
}

  $del = $con->prepare("DELETE FROM post WHERE id=:id");

  $del->bindValue(':id', $id);
  $del->execute();

header("Location: /mybbs/index.php"); 
