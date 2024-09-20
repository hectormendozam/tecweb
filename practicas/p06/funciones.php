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

        // Crear la tabla XHTML
        echo "<table border='1'>";
        echo "<tr><th>Índice</th><th>Valor</th></tr>";

        foreach ($arreglo as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }

        echo "</table>";
    };
    
?>
</body>
</html>