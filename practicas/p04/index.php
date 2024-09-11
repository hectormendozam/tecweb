<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
        unset($_myvar, $_7var, $myvar, $var7, $_element1);
    ?>

    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <li>$a = “ManejadorSQL”;</li>
    <li>$b = 'MySQL’;</li>
    <li>$c = &$a;</li>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;
        
        echo '<h4>Ahora muestra el contenido de cada variable:</h4>';
        echo '<ul>';
        echo "<li>Variable a: $a</li>";
        echo "<li>Variable b: $b</li>";
        echo "<li>Variable c: $c</li>";
        echo '</ul>';

        echo 'Realizamos las siguientes asignaciones:<br><br>';
        echo '<li>$a = "PHP server";</li>';
        echo '<li>$b = &$a;</li>';

        $a = "PHP server";
        $b = &$a;

        echo '<h4>Volvemos a imprimir las variables después de haber realizado las nuevas asignaciones:</h4>';
        echo '<ul>';
        echo "<li>Variable a: $a</li>";
        echo "<li>Variable b: $b</li>";
        echo "<li>Variable c: $c</li>";
        echo '</ul>';

        echo 'Respuesta: Lo que ocurrió al realizar las nuevas asignaciones es que la variable $b se convirtió en una referencia de la variable $a, por lo que al modificar el valor de $a a PHP server, también se modifica el valor de $b.'; 
        unset($a, $b, $c);
    ?>

    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación, verificar la evolución del tipo de estas variables: </p>
    <li>$a = “PHP5”;</li>
    <li>$z[] = &$a;</li>
    <li>$b = “5a version de PHP”;</li>
    <li>$c = $b*10;</li>
    <li>$a .= $b;</li>
    <li>$b *= $c;</li>
    <li>$z[0] = “MySQL”;</li>

    <?php
        //AQUI VA MI CÓDIGO PHP
        echo '<h4>Mostramos cada variable o arreglo después de su asignación: </h4>';
        $a = "PHP5";
        var_dump($a);
        echo '<br>';

        $z[] = &$a;
        print_r($z); 
        echo '<br>';

        $b = "5a version de PHP";
        var_dump($b); 
        echo '<br>';

        $c = $b * 10; 
        var_dump($c); 
        echo '<br>';

        $a .= $b; 
        var_dump($a);
        echo '<br>';    

        $b *= $c;
        var_dump($b);
        echo '<br>';

        $z[0] = "MySQL";
        print_r($z);
        echo '<br>';

    ?>

    <h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de la matriz $GLOBALS o del modificador global de PHP.</p>

    <?php
        //AQUI VA MI CÓDIGO PHP
        echo '<h4>Mostramos cada variable o arreglo después de su asignación: </h4>';
        $a = "PHP5";
        $GLOBALS['a'] = $a;
        var_dump($GLOBALS['a']); 
        echo '<br>';

        $z[0] = &$a;
        $GLOBALS['z'] = $z;
        print_r($GLOBALS['z']); 
        echo '<br>';

        $b = "5a version de PHP";
        $GLOBALS['b'] = $b;
        var_dump($GLOBALS['b']); 
        echo '<br>';

        $c = (int)$b * 10;        
        $GLOBALS['c'] = $c;
        var_dump($GLOBALS['c']); 
        echo '<br>';

        $a .= $b;
        $GLOBALS['a'] = $a;
        var_dump($GLOBALS['a']); 
        echo '<br>';

        $b = (int)$b * $c;
        $GLOBALS['b'] = $b;
        var_dump($GLOBALS['b']); 
        echo '<br>';

        $z[0] = "MySQL";
        $GLOBALS['z'] = $z;
        print_r($GLOBALS['z']);
        echo '<br>';

    ?>
</body>
</html>