<?php
    use TECWEB\MYAPI\Read;

    require_once __DIR__.'/vendor/autoload.php';

    $productos = new Read('marketzone');
    $productos->list();
    echo $productos->getData();
?>