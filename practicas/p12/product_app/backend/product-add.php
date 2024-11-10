<?php
    use TECWEB\MYAPI\Create;
    require_once __DIR__.'/vendor/autoload.php';

    $productos = new Products('marketzone');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>