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
    }
    
?>
</body>
</html>