<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <?php
    function esMultiplo($num){
        if(isset($_GET['numero']))
        {
        $num = $_GET['numero'];
        if ($num%5==0 && $num%7==0)
        {
            echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
        }
        else
        {
            echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
        }
        }
    }

    function generarImparParImpar(){
        function esImpar($numero) {
            return $numero % 2 != 0;
        }
    
        function esPar($numero) {
            return $numero % 2 == 0;
        }
    
        $matriz = [];
        $iteraciones = 0;
        $totalNumerosGenerados = 0;
    
        do {
            $iteraciones++;
    
            $num1 = rand(1, 100);  
            $num2 = rand(1, 100);
            $num3 = rand(1, 100);
    
            $matriz[] = [$num1, $num2, $num3];
    
            $totalNumerosGenerados += 3;
    
            // echo "Iteración $iteraciones: [$num1, $num2, $num3]". '<br>';
    
        } while (!(esImpar($num1) && esPar($num2) && esImpar($num3))); 
    
        echo "Número total de iteraciones: $iteraciones". '<br>';
        echo "Cantidad total de números generados: $totalNumerosGenerados". '<br>'. '<br>';
    
        echo "\nMatriz de números generados:". '<br>';
        foreach ($matriz as $fila) {
            echo "[" . implode(", ", $fila) . "]". '<br>';
        }
    }

    function esMultiploAleatorio(){
        if (isset($_GET['number']) && $_GET['number'] != 0) {
        while (true){
            $random = rand(1, 100);
            if ($random % $_GET['number'] == 0){
                echo 'El número generado aleatoriamente '. $random .' es múltiplo de ' . $_GET['number'];
                break;
            }
        }
    }
    };

    function esMultiploAleatoriov2(){
        if (isset($_GET['number']) && $_GET['number'] != 0) {
        do {
            $random = rand(1, 100);
            if ($random % $_GET['number'] == 0){
                echo 'El número generado aleatoriamente ' . $random . ' es múltiplo de ' . $_GET['number'];
                break;
            }
        } while (rand(1, 100) % $_GET['number'] !== 0);
    }
    };

    function numerosASCII() {
        $arreglo = array();
        for ($i = 97; $i <= 122; $i++) {
            $arreglo[$i] = chr($i);
        }

        echo "<table border='1'>";
        echo "<tr><th>Índice</th><th>Valor</th></tr>";

        foreach ($arreglo as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }

        echo "</table>";
    };

    function formularioEdadSexo(){
        if (isset($_POST['edad']) && isset($_POST['sexo'])) {
            // Obtener los valores enviados por el formulario
            $edad = $_POST['edad'];
            $sexo = $_POST['sexo'];
        
            // Generar la respuesta en XHTML
            echo '<?xml version="1.0" encoding="UTF-8"?>';
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
            echo '<html xmlns="http://www.w3.org/1999/xhtml">';
            echo '<head><title>Respuesta</title></head>';
            echo '<body>';
        
            // Validar las condiciones
            if ($sexo == 'femenino' && $edad >= 18 && $edad <= 35) {
                echo '<h2>Bienvenida, usted está en el rango de edad permitido.</h2>';
            } else {
                echo '<h2>Lo siento, usted no cumple con los criterios de acceso.</h2>';
            }
        
            echo '</body>';
            echo '</html>';
            } else {
                // En caso de que no se reciban los datos
                echo '<h2>Error: No se recibieron los datos del formulario.</h2>';
            }
    };

    function registroAutos(){

    // Arreglo con los 15 autos registrados
    $parque_vehicular = array(
        'ABC1234' => array(
            'Auto' => array(
                'marca' => 'Toyota',
                'modelo' => 2020,
                'tipo' => 'sedan'
            ),
            'Propietario' => array(
                'nombre' => 'Juan Pérez',
                'ciudad' => 'Ciudad de México',
                'direccion' => 'Av. Insurgentes Sur 123'
            )
        ),
        'DEF5678' => array(
            'Auto' => array(
                'marca' => 'Honda',
                'modelo' => 2018,
                'tipo' => 'camioneta'
            ),
            'Propietario' => array(
                'nombre' => 'Ana Gómez',
                'ciudad' => 'Guadalajara',
                'direccion' => 'Calle Libertad 45'
            )
        ),
        'GHI9123' => array(
            'Auto' => array(
                'marca' => 'Mazda',
                'modelo' => 2019,
                'tipo' => 'hatchback'
            ),
            'Propietario' => array(
                'nombre' => 'Carlos López',
                'ciudad' => 'Monterrey',
                'direccion' => 'Calle Zaragoza 789'
            )
        ),
        'JKL4567' => array(
            'Auto' => array(
                'marca' => 'Ford',
                'modelo' => 2017,
                'tipo' => 'sedan'
            ),
            'Propietario' => array(
                'nombre' => 'Laura Méndez',
                'ciudad' => 'Puebla',
                'direccion' => 'Av. Reforma 45'
            )
        ),
        'MNO7890' => array(
            'Auto' => array(
                'marca' => 'Chevrolet',
                'modelo' => 2021,
                'tipo' => 'camioneta'
            ),
            'Propietario' => array(
                'nombre' => 'Luis García',
                'ciudad' => 'Toluca',
                'direccion' => 'Calle Independencia 78'
            )
        ),
        'PQR3456' => array(
            'Auto' => array(
                'marca' => 'Volkswagen',
                'modelo' => 2016,
                'tipo' => 'hatchback'
            ),
            'Propietario' => array(
                'nombre' => 'Sofía Martínez',
                'ciudad' => 'León',
                'direccion' => 'Calle del Sol 32'
            )
        ),
        'STU5678' => array(
            'Auto' => array(
                'marca' => 'Nissan',
                'modelo' => 2019,
                'tipo' => 'sedan'
            ),
            'Propietario' => array(
                'nombre' => 'Miguel Sánchez',
                'ciudad' => 'Querétaro',
                'direccion' => 'Blvd. Bernardo Quintana 123'
            )
        ),
        'VWX9012' => array(
            'Auto' => array(
                'marca' => 'Kia',
                'modelo' => 2020,
                'tipo' => 'camioneta'
            ),
            'Propietario' => array(
                'nombre' => 'Patricia Ramírez',
                'ciudad' => 'Mérida',
                'direccion' => 'Calle 60 450'
            )
        ),
        'YZA1234' => array(
            'Auto' => array(
                'marca' => 'Hyundai',
                'modelo' => 2022,
                'tipo' => 'sedan'
            ),
            'Propietario' => array(
                'nombre' => 'Gabriel Torres',
                'ciudad' => 'Cancún',
                'direccion' => 'Av. Tulum 20'
            )
        ),
        'BCD5678' => array(
            'Auto' => array(
                'marca' => 'Renault',
                'modelo' => 2015,
                'tipo' => 'hatchback'
            ),
            'Propietario' => array(
                'nombre' => 'Fernanda Castro',
                'ciudad' => 'Tijuana',
                'direccion' => 'Calle Revolución 90'
            )
        ),
        'EFG9012' => array(
            'Auto' => array(
                'marca' => 'Jeep',
                'modelo' => 2021,
                'tipo' => 'camioneta'
            ),
            'Propietario' => array(
                'nombre' => 'Roberto Flores',
                'ciudad' => 'Ciudad Juárez',
                'direccion' => 'Blvd. Zaragoza 230'
            )
        ),
        'HIJ2345' => array(
            'Auto' => array(
                'marca' => 'Fiat',
                'modelo' => 2018,
                'tipo' => 'sedan'
            ),
            'Propietario' => array(
                'nombre' => 'Valeria Aguilar',
                'ciudad' => 'Puebla',
                'direccion' => 'Calle 14 Sur 123'
            )
        ),
        'KLM6789' => array(
            'Auto' => array(
                'marca' => 'Peugeot',
                'modelo' => 2017,
                'tipo' => 'hatchback'
            ),
            'Propietario' => array(
                'nombre' => 'Mauricio Rodríguez',
                'ciudad' => 'Morelia',
                'direccion' => 'Calle Madero 56'
            )
        ),
        'NOP1234' => array(
            'Auto' => array(
                'marca' => 'Audi',
                'modelo' => 2020,
                'tipo' => 'camioneta'
            ),
            'Propietario' => array(
                'nombre' => 'Daniela Morales',
                'ciudad' => 'Monterrey',
                'direccion' => 'Av. Constitución 105'
            )
        ),
        'QRS3456' => array(
            'Auto' => array(
                'marca' => 'BMW',
                'modelo' => 2021,
                'tipo' => 'sedan'
            ),
            'Propietario' => array(
                'nombre' => 'Ignacio Ramírez',
                'ciudad' => 'Guadalajara',
                'direccion' => 'Calle Hidalgo 67'
            )
        ),
    );

    echo '<br>';
    //print_r($parque_vehicular);

    // Comienza la estructura XHTML
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
    echo '<!DOCTYPE html>';
    echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="es">';
    echo '<head>';
    echo '<title>Consulta de Parque Vehicular</title>';
    echo '</head>';
    echo '<body>';

    // Consulta por matrícula
    if (isset($_POST['matricula'])) {
        $matricula = strtoupper(trim($_POST['matricula'])); // Convertir a mayúsculas
        if (array_key_exists($matricula, $parque_vehicular)) {
            echo "<h3>Información del vehículo con matrícula $matricula:</h3>";
            echo "<p><strong>Marca:</strong> " . $parque_vehicular[$matricula]['Auto']['marca'] . "</p>";
            echo "<p><strong>Modelo:</strong> " . $parque_vehicular[$matricula]['Auto']['modelo'] . "</p>";
            echo "<p><strong>Tipo:</strong> " . $parque_vehicular[$matricula]['Auto']['tipo'] . "</p>";
            echo "<p><strong>Propietario:</strong> " . $parque_vehicular[$matricula]['Propietario']['nombre'] . "</p>";
            echo "<p><strong>Ciudad:</strong> " . $parque_vehicular[$matricula]['Propietario']['ciudad'] . "</p>";
            echo "<p><strong>Dirección:</strong> " . $parque_vehicular[$matricula]['Propietario']['direccion'] . "</p>";
        } else {
            echo "<h3>No se encontró información para la matrícula $matricula.</h3>";
        }
    }
    // Consulta de todos los autos
    if (isset($_POST['todos'])) {
    echo "<h3>Todos los vehículos registrados:</h3>";
    foreach ($parque_vehicular as $matricula => $info) {
        echo "<h4>Matrícula: $matricula</h4>";
        echo "<p><strong>Marca:</strong> " . $info['Auto']['marca'] . "</p>";
        echo "<p><strong>Modelo:</strong> " . $info['Auto']['modelo'] . "</p>";
        echo "<p><strong>Tipo:</strong> " . $info['Auto']['tipo'] . "</p>";
        echo "<p><strong>Propietario:</strong> " . $info['Propietario']['nombre'] . "</p>";
        echo "<p><strong>Ciudad:</strong> " . $info['Propietario']['ciudad'] . "</p>";
        echo "<p><strong>Dirección:</strong> " . $info['Propietario']['direccion'] . "</p>";
        echo "<hr />";
    }
}

echo '</body>';
echo '</html>';
};
    
?>
</body>
</html>