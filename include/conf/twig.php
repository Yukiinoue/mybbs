<?php

// twig
require 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'debug' => true,
    ));
$twig->addExtension(new Twig_Extension_Debug());

// テンプレートの呼び出し
function twig_view ($twig, $file, $output, $message)
{
    $template = $twig->load($file);
    echo $template->render(['output' => $output, 'message' => $message]);
}