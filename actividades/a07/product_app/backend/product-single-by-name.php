<?php

    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $productos = new Products('marketzone');
    $productos->singleByName($_POST['name']);
    echo $productos->getData();

?>