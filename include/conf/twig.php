<?php
// テンプレートの呼び出し
function twig_view ($file, $data)
{
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, array(
    'debug' => true,
    ));
    $twig->addExtension(new Twig_Extension_Debug());

    $template = $twig->load($file);
    echo $template->render(['data' => $data]);
}
