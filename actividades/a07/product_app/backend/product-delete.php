<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__.'/myapi/Products.php';
    
    $productos = new Products('marketzone');
    $productos->delete($_GET['id']);
    echo $productos->getData();
?>