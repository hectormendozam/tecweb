<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 3</title>
</head>
<body>
    <?php
        /* use EJEMPLOS\POO\Cabecera as Cabecera;
        require_once __DIR__.'/Cabecera.php';

        $cab = new Cabecera('El Rincón del Programador', 'center');
        $cab->graficar(); */

        use EJEMPLOS\POO\Cabecera2 as Cabecera;
        require_once __DIR__.'/Cabecera.php';

        $cab = new Cabecera('El Rincón del Programador', 'center', 'https://www.cs.buap.mx');
        $cab->graficar();
    ?>
</body>
</html>