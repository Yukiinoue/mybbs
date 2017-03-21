<?php

require "include/model/db.php";

$con = db_connect();

$id = isset($_GET['id'])? $_GET['id'] : null;

$sth = $con->prepare("SELECT * FROM file WHERE `post_id` = :post_id");
$sth->bindValue(':post_id', $id);
$sth->execute();
$files_data = $sth->fetch(PDO::FETCH_OBJ);

header("Content-Type: image/jpeg");
echo $files_data->contents;

