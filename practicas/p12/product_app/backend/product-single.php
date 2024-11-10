<?php
    use TECWEB\MYAPI\Read;
    require_once __DIR__.'/myapi/Products.php';

    $productos = new Read('marketzone');
    $productos->single( $_POST['id'] );
    echo $productos->getData();
?>