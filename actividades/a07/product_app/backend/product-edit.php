<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $productos = new Products('marketzone');

    $productos->edit(json_decode(file_get_contents('php://input')));
    echo $productos->getData();
?>