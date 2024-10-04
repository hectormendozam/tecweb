<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión a la base de datos
    @$link = new mysqli('localhost', 'root', '12345678', 'marketzone');

    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    // Capturar los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $precio = isset($_POST['precio']) ? (float)$_POST['precio'] : 0.0;
    $detalles = $_POST['detalles'] ?? '';
    $unidades = isset($_POST['unidades']) ? (int)$_POST['unidades'] : 0;
    $imagen = $_POST['imagen'] ?? '';

    // Verificar si el producto ya existe
    $stmt = $link->prepare("SELECT COUNT(*) FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?");
    if ($stmt === false) {
        die('Error al preparar la consulta: ' . $link->error);
    }

    $stmt->bind_param("sss", $nombre, $marca, $modelo);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<p>El producto con nombre '$nombre', marca '$marca' y modelo '$modelo' ya existe en la base de datos.</p>";
    } else {
        // Insertar el nuevo producto
        $stmt = $link->prepare("INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
        if ($stmt === false) {
            die('Error al preparar la consulta: ' . $link->error);
        }

        $stmt->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);

        if ($stmt->execute()) {
            echo "<p>Producto insertado correctamente:</p>";
            echo "<ul>";
            echo "<li>Nombre: $nombre</li>";
            echo "<li>Marca: $marca</li>";
            echo "<li>Modelo: $modelo</li>";
            echo "<li>Precio: $precio</li>";
            echo "<li>Detalles: $detalles</li>";
            echo "<li>Unidades: $unidades</li>";
            echo "<li>Imagen: $imagen</li>";
            echo "</ul>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $link->close();
}
?>