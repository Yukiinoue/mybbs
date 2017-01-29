<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

require 'index.php';

// twig
require 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'debug' => true,
    ));
$twig->addExtension(new Twig_Extension_Debug());


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
    $parent_id = $_POST['post_id'];
    $template = $twig->load('reply.html');
    echo $template->render(['parent_id' => $parent_id, 'message' => $message]);
