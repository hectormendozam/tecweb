<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        '12345678',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>