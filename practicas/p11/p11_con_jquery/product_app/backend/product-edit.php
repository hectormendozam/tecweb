<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
$data = array(
    'status'  => 'error',
    'message' => 'No se encontró el producto o ocurrió un error'
);

if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // Verificar que el id del producto existe en el JSON
    if (isset($jsonOBJ->id)) {
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $id = $jsonOBJ->id;
        $sql = "SELECT * FROM productos WHERE id = '{$id}' AND eliminado = 0";
        $result = $conexion->query($sql);

        // Verificar si existe el producto con el id proporcionado
        if ($result->num_rows > 0) {
            // SE PREPARA EL UPDATE
            $conexion->set_charset("utf8");
            $sql = "UPDATE productos SET
                        nombre = '{$jsonOBJ->nombre}',
                        marca = '{$jsonOBJ->marca}',
                        modelo = '{$jsonOBJ->modelo}',
                        precio = {$jsonOBJ->precio},
                        detalles = '{$jsonOBJ->detalles}',
                        unidades = {$jsonOBJ->unidades},
                        imagen = '{$jsonOBJ->imagen}'
                    WHERE id = '{$id}' AND eliminado = 0";

            // Ejecutar la consulta de actualización
            if ($conexion->query($sql)) {
                $data['status'] = "success";
                $data['message'] = "Producto actualizado correctamente";
            } else {
                $data['message'] = "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conexion);
            }
        } else {
            // Producto no encontrado
            $data['message'] = "No se encontró el producto con el id especificado.";
        }

        $result->free();
    } else {
        // Error si no se envió el id
        $data['message'] = "El id del producto no fue proporcionado en el JSON.";
    }

    // Cerrar la conexión
    $conexion->close();
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>