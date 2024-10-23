<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if (!empty($producto)) {
        $jsonOBJ = json_decode($producto);
    
        // Validar que el nombre no esté vacío
        if (empty($jsonOBJ->nombre)) {
            $data['message'] = 'El nombre del producto es obligatorio.';
            exit;
        }
    
        // Verificar si el producto ya existe
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
        $result = $conexion->query($sql);
    
        if ($result === false) {
            $data['message'] = "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conexion);
        } elseif ($result->num_rows > 0) {
            // Producto ya existe
            $data['message'] = 'Ya existe un producto con ese nombre';
        } else {
            // Insertar el nuevo producto
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES ('{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            
            if ($conexion->query($sql)) {
                $data['status'] = "success";
                $data['message'] = "Producto agregado correctamente.";
            } else {
                $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
            }
        }
    
        $result->free();
        $conexion->close();
    }
    
    echo json_encode($data, JSON_PRETTY_PRINT);

?>