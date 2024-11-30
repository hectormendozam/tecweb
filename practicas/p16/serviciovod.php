<?php
libxml_use_internal_errors(true);

$xml= new DOMDocument();

$xml->load('catalogovodN.xml');

// o usa $xml->load si prefieres usar la ruta del archivo
$xsd = 'serviciovod.xsd';
if (!$xml->schemaValidate($xsd))
// o usa $xml->schemaValidateSource si prefieres usar el xsd en format string
{
$errors = libxml_get_errors();
$noError = 1;
$lista = '';
foreach ($errors as $error)
{
$lista = $lista.'['.($noError++).']: '.$error->message.'."<br>" ';
}
echo $lista;
exit;
}

$documento = file_get_contents('catalogovodN.xml');
if ($documento === false) {
    die('Error: No se pudo cargar el archivo catalogovodN.xml');
}

$xmlSimple = simplexml_load_string($documento);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/strict.dtd">';
echo '<html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
echo '<title>Catálogo VOD</title>';
echo '<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
            text-align: center;
        }
        .table-title {
            background-color: #3498db;
            color: white;
            font-size: 1.2em;
            text-align: center;
        }
    </style>';
echo '</head>';
echo '<body>';
echo '<img class="logo" src="logo.png" alt="Logotipo VOD">';
echo '<h1>Catálogo de Películas</h1>';
echo '<table>';
echo '<tr><th class="table-title" colspan="3">Películas</th></tr>';
echo '<tr><th>Título</th><th>Duración</th><th>Género</th></tr>';

foreach ($xmlSimple->contenido->peliculas->genero as $genero) {
    foreach ($genero->titulo as $titulo) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($titulo) . '</td>';
        echo '<td>' . htmlspecialchars($titulo['duracion']) . '</td>';
        echo '<td>' . htmlspecialchars($genero['nombre']) . '</td>';
        echo '</tr>';
    }
}

echo '</table>';
echo '<h1>Catálogo de Series</h1>';
echo '<table>';
echo '<tr><th class="table-title" colspan="3">Series</th></tr>';
echo '<tr><th>Título</th><th>Duración</th><th>Género</th></tr>';

foreach ($xmlSimple->contenido->series->genero as $genero) {
    foreach ($genero->titulo as $titulo) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($titulo) . '</td>';
        echo '<td>' . htmlspecialchars($titulo['duracion']) . '</td>';
        echo '<td>' . htmlspecialchars($genero['nombre']) . '</td>';
        echo '</tr>';
    }
}

echo '</table>';
echo '</body>';
echo '</html>';
?>