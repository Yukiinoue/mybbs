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

// templateの出力
    $parent_id = $_POST['post_id'];
    $template = $twig->load('reply.html');
    echo $template->render(['parent_id' => $parent_id, 'message' => $message]);
