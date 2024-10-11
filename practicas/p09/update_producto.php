<?php
/* MySQL Conexion*/
$link = mysqli_connect("localhost", "root", "12345678", "marketzone");
// Chequea coneccion
if($link === false){
die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Obtener datos del formulario
$id = (int)$_POST['id'];  // Forzar el ID a ser un entero
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$unidades = $_POST['unidades'];
$detalles = $_POST['detalles'];
$imagen = $_POST['imagen'];

$stmt = mysqli_prepare($link, "UPDATE productos SET nombre=?, marca=?, modelo=?, precio=?, unidades=?, detalles=?, imagen=? 
                                WHERE id=?");
mysqli_stmt_bind_param($stmt, "sssidssi", $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen, $id);

echo "Consulta SQL: UPDATE productos SET nombre=$nombre, marca=$marca, modelo=$modelo, precio=$precio, unidades=$unidades, detalles=$detalles, imagen=$imagen WHERE id=$id";

// Ejecutar la actualización
if(mysqli_stmt_execute($stmt)){
    echo "<h3>Producto actualizado correctamente.</h3>";
} else {
    echo "ERROR: No se pudo actualizar el producto. " . mysqli_error($link);
}

// Cerrar la conexión
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<a href="get_productos_xhtml_v2.php" class="btn btn-link">Ver Productos en XHTML</a><br><br>
<a href="get_productos_vigentes_v2.php" class="btn btn-link">Ver Productos Vigentes</a>