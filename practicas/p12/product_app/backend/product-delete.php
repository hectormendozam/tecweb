<?php
    use TECWEB\MYAPI\Products;
    require_once __DIR__.'/vendor/autoload.php';

    $productos = new Products('marketzone');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>