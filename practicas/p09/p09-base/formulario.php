<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
    ol, ul { 
    list-style-type: none;
    }
    </style>
    <title>Formulario</title>
</head>
<body>
    <h1>Datos Personales</h1>

    <form id="miFormulario" onsubmit="" method="post">
        <fieldset>
            <legend>Actualiza los datos personales de esta persona:</legend>
            <ul>
                <li><label>Nombre:</label> 
                <input type="text" name="name" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : (isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '') ?>">
                <li><label>Edad:</label> 
                <input type="text" name="age" value="<?= isset($_POST['edad']) ? htmlspecialchars($_POST['edad']) : (isset($_GET['edad']) ? htmlspecialchars($_GET['edad']) : '') ?>">
            </ul>
        </fieldset>
        <p>
            <input type="submit" value="ENVIAR">
        </p>
    </form>
</body>
</html>