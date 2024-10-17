<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_POST['search']) ) {
        $search = $conexion->real_escape_string($_POST['search']); // Se asegura de escapar el input para evitar inyecciones SQL

        // SE REALIZA LA QUERY DE BÚSQUEDA CON LA CLÁUSULA LIKE
        $query = "SELECT * FROM productos 
                WHERE nombre LIKE '%{$search}%' 
                OR marca LIKE '%{$search}%' 
                OR detalles LIKE '%{$search}%'";
        
        // SE EJECUTA LA QUERY Y SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query($query) ) {
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $product = array();
                foreach($row as $key => $value) {
                    $product[$key] = utf8_encode($value);
                }
                $data[] = $product;
            }
            $result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>