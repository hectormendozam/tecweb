<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
    include 'funciones.php';
        esMultiplo(0);
    ?>

    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta por: impar, par e impar</p>

    <p>Estos números deben almacenarse en una matriz de Mx3, donde M es el número de filas y
    3 el número de columnas. Al final muestra el número de iteraciones y la cantidad de
    números generados.</p>
    <?php
        generarImparParImpar();
    ?>

    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.</p>
    <form> 
        <input type="text" name="number" placeholder="Ingrese un número">
        <input type="submit" value="Encontrar número al azar que sea múltiplo">
    </form>
    <?php        
        esMultiploAleatorio();
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
    a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
    el valor en cada índice.</p>

    <li>Crea el arreglo con un ciclo for</li>
    <li>Lee el arreglo y crea una tabla en XHTML con echo y un ciclo foreach</li>
    <?php
        numerosASCII();
    ?>

    <h2>Ejercicio 5 - Formulario de Edad y Sexo</h2>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="POST">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required><br><br>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select><br><br>

        <input type="submit" value="Enviar">
    </form>
    <?php
        formularioEdadSexo();
    ?>

    <h2>Ejercicio 6 - Registro de autos</h2>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="POST">
        <label for="matricula">Ingrese la matrícula del vehículo:</label>
        <input type="text" id="matricula" name="matricula" placeholder="Ej: ABC1234">
        <input type="submit" value="Consultar">
    </form>
    
    <!-- Formulario para consultar todos los vehículos -->
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="POST">
        <input type="hidden" name="todos" value="true">
        <input type="submit" value="Consultar todos los autos registrados">
    </form>
    <?php
    registroAutos();
    
    ?>
</body>
</html>