<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cargar el archivo XML
    $xmlFile = 'catalogovodN.xml';
    $xml = new DOMDocument();
    $xml->load($xmlFile);

    // Leer los datos del formulario
    $usuario = $_POST['usuario'];
    $idioma = $_POST['idioma'];
    $peliculasGenero = $_POST['peliculas_genero'];
    $peliculasTitulos = explode(',', $_POST['peliculas_titulos']);
    $seriesGenero = $_POST['series_genero'];
    $seriesTitulos = explode(',', $_POST['series_titulos']);

    // Agregar un nuevo perfil
    $perfil = $xml->createElement('perfil');
    $perfil->setAttribute('usuario', $usuario);
    $perfil->setAttribute('idioma', $idioma);

    $perfiles = $xml->getElementsByTagName('perfiles')->item(0);
    $perfiles->appendChild($perfil);

    // Agregar un nuevo género en películas
    $peliculas = $xml->getElementsByTagName('peliculas')->item(0);
    $generoPeliculas = $xml->createElement('genero');
    $generoPeliculas->setAttribute('nombre', $peliculasGenero);

    foreach ($peliculasTitulos as $tituloDuracion) {
        list($titulo, $duracion) = explode('|', $tituloDuracion);
        $tituloNodo = $xml->createElement('titulo', htmlspecialchars(trim($titulo)));
        $tituloNodo->setAttribute('duracion', trim($duracion));
        $generoPeliculas->appendChild($tituloNodo);
    }

    $peliculas->appendChild($generoPeliculas);

    // Agregar un nuevo género en series
    $series = $xml->getElementsByTagName('series')->item(0);
    $generoSeries = $xml->createElement('genero');
    $generoSeries->setAttribute('nombre', $seriesGenero);

    foreach ($seriesTitulos as $tituloDuracion) {
        list($titulo, $duracion) = explode('|', $tituloDuracion);
        $tituloNodo = $xml->createElement('titulo', htmlspecialchars(trim($titulo)));
        $tituloNodo->setAttribute('duracion', trim($duracion));
        $generoSeries->appendChild($tituloNodo);
    }

    $series->appendChild($generoSeries);

    // Descargar el archivo XML actualizado
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="catalogovodN_updated.xml"');
    echo $xml->saveXML();
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar elementos al catálogo VOD</title>
    <style>
        /* Reiniciar márgenes y paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            color: #333;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
            text-align: center;
        }
        .contenedor-h1 {
            background-color: #3498db; /* Fondo para destacar el encabezado */
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .contenedor-h1 h1 {
            color: white;
            font-size: 1.5em;
            margin: 0;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 1.3em;
        }
        button:hover {
            background-color: #2c3e50;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
        }
        h2 {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <img class="logo" src="logo.png" alt="Logotipo VOD">
        <div class="contenedor-h1">
            <h1>Agregar elementos al catálogo VOD</h1>
        </div>
        <form method="post">
            <h2>Agregar nuevo perfil</h2>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
            
            <label for="idioma">Idioma:</label>
            <input type="text" id="idioma" name="idioma" required>

            <h2>Agregar género a películas</h2>
            <label for="peliculas_genero">Nombre del género:</label>
            <input type="text" id="peliculas_genero" name="peliculas_genero" required>

            <label for="peliculas_titulos">Títulos (Formato: Título|Duración separados por comas):</label>
            <input type="text" id="peliculas_titulos" name="peliculas_titulos" placeholder="Ejemplo: Título1|1h 30min,Título2|2h" required>

            <h2>Agregar género a series</h2>
            <label for="series_genero">Nombre del género:</label>
            <input type="text" id="series_genero" name="series_genero" required>

            <label for="series_titulos">Títulos (Formato: Título|Duración separados por comas):</label>
            <input type="text" id="series_titulos" name="series_titulos" placeholder="Ejemplo: Título1|1 temporada,Título2|2 temporadas" required>

            <button type="submit">Agregar al XML</button>
        </form>
    </div>
</body>
</html>
