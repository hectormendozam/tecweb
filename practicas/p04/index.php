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
    <ul>
    <li>$a = “ManejadorSQL”;</li>
    <li>$b = 'MySQL’;</li>
    <li>$c = &amp;$a;</li>
    </ul>
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
    <ul>
    <li>$a = “PHP5”;</li>
    <li>$z[] = &amp;$a;</li>
    <li>$b = “5a version de PHP”;</li>
    <li>$c = $b*10;</li>
    <li>$a .= $b;</li>
    <li>$b *= $c;</li>
    <li>$z[0] = “MySQL”;</li>
    </ul>

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

        @ $c = $b * 10; 
        var_dump($c); 
        echo '<br>';

        $a .= $b; 
        var_dump($a);
        echo '<br>';    

        @ $b *= $c;
        var_dump($b);
        echo '<br>';

        $z[0] = "MySQL";
        print_r($z);
        echo '<br>';
        unset($a, $b, $c, $z);
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
        unset($a, $b, $c, $z);
    ?>

    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <ul>
    <li>$a = “7 personas”;</li>
    <li>$b = (integer) $a;</li>
    <li>$a = “9E3”;</li>
    <li>$c = (double) $a;</li>
    </ul>

    <?php
        //AQUI VA MI CÓDIGO PHP
        echo '<h4>Mostramos el valor de las variables $a, $b, $c al final del anterior script: </h4>';
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo '<ul>';
        echo "<li>Variable a: $a</li>";
        echo "<li>Variable b: $b</li>";
        echo "<li>Variable c: $c</li>";
        echo '</ul>';
        unset($a, $b, $c);
    ?>

    <h2>Ejercicio 6</h2>
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas usando la función var_dump().</p>
    <ul>
    <li>$a = “0”;</li>
    <li>$b = “TRUE”;</li>
    <li>$c = FALSE;</li>
    <li>$d = ($a OR $b);</li>
    <li>$e = ($a AND $c);</li>
    <li>$f = ($a XOR $b);</li>
    </ul>

    <?php
        //AQUI VA MI CÓDIGO PHP
        echo '<h4>Comprobamos el valor booleano de las variables y las mostramos con var_dump(): </h4>';
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);

        var_dump($a);
        echo '<br>'; 
        var_dump($b); 
        echo '<br>'; 
        var_dump($c); 
        echo '<br>';
        var_dump($d); 
        echo '<br>';
        var_dump($e); 
        echo '<br>';
        var_dump($f); 
        echo '<br><br>';
        echo 'Explicación: Las primeras dos variables son de tipo string, por lo que no se les asigna un valor booleano.';

        echo '<h4>Después investiga una función de PHP que permita transformar el valor booleano de $c y $e en uno que se pueda mostrar con un echo:</h4>';
        echo 'Utilizamos la función var_export() para mostrar el valor booleano de $c y $e con echo:';
        // Para mostrar valores booleanos con echo, usamos var_export()
        echo '<br>';
        echo 'Valor de la variable $c: '.var_export($c, true); 
        echo '<br>';
        echo 'Valor de la variable $e: '.var_export($e, true); 
        echo '<br>';
        unset($a, $b, $c, $d, $e, $f);
    ?>

    <h2>Ejercicio 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina lo siguiente:</p>
    <ul>
    <li>La versión de Apache y PHP</li>
    <li>El nombre del sistema operativo (servidor)</li>
    <li>El idioma del navegador (cliente).</li>
    </ul>

    <?php
        //AQUI VA MI CÓDIGO PHP
        echo '<h4>Mostramos las versiones, nombre del OS e idioma del navegador: </h4>';
        echo "Versión de Apache y PHP: " . $_SERVER['SERVER_SOFTWARE'];
        echo '<br>';
        echo "Sistema operativo del servidor: " . php_uname('s');
        echo '<br>';
        echo "Idioma del navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    ?>

    <p>
        <a href="https://validator.w3.org/markup/check?uri=referer"><img
        src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
    </p>
</body>
</html>