<?php 
  function dbConnect ()
  {
    $con = new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8','appuser','eDZNQ7ZnMuDm');
    return $con;
  }