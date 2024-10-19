<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    if (!empty($producto)) {
        // SE TRANSFORMA EL STRING JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        $nombre = $conexion->real_escape_string($jsonOBJ->nombre);
        $precio = $jsonOBJ->precio;
        $unidades = $jsonOBJ->unidades;
        $modelo = $jsonOBJ->modelo;
        $marca = $jsonOBJ->marca;
        $detalles = $jsonOBJ->detalles;
        $imagen = $jsonOBJ->imagen;

        // CONSULTA PARA VERIFICAR SI YA EXISTE EL PRODUCTO CON EL MISMO NOMBRE Y "eliminado" EN 0
        $query_check = "SELECT * FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
        $result_check = $conexion->query($query_check);

        if ($result_check->num_rows > 0) {
            // SI EL PRODUCTO YA EXISTE
            echo json_encode(array('status' => 'error', 'message' => 'El producto ya existe en la base de datos.'));
        } else {
            // SI EL PRODUCTO NO EXISTE, PROCEDE A INSERTAR
            $query_insert = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen, eliminado) 
                            VALUES ('$nombre', '$precio', '$unidades', '$modelo', '$marca', '$detalles', '$imagen', 0)";
                            
            if ($conexion->query($query_insert)) {
                // ÉXITO EN LA INSERCIÓN
                echo json_encode(array('status' => 'success', 'message' => 'Producto insertado exitosamente.'));
            } else {
                // ERROR EN LA INSERCIÓN
                echo json_encode(array('status' => 'error', 'message' => 'Error al insertar el producto: ' . $conexion->error));
            }
        }
        
        $result_check->free();
        $conexion->close();
    } else {
        // CASO CUANDO NO SE RECIBE EL PRODUCTO
        echo json_encode(array('status' => 'error', 'message' => 'No se recibieron datos del producto.'));
    }
?>