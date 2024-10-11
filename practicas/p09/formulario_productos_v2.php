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
    <h1>Datos para Registro de Relojes</h1>

    <form id="miFormulario" method="POST" action="update_producto.php">
        <fieldset>
            <legend>Actualiza los datos del reloj</legend>
            <ul>
            <li><label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : (isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '') ?>" required>
            </li><br>
            <li><label for="marcas">Selecciona una marca:</label>
            <select id="marcas" name="marca" required>
                <option value="" selected disabled>Elige una opción</option>
                <option value="garmin" <?= isset($_POST['marca']) && $_POST['marca'] == 'garmin' ? 'selected' : (isset($_GET['marca']) && $_GET['marca'] == 'garmin' ? 'selected' : '') ?>>Garmin</option>
                <option value="apple" <?= isset($_POST['marca']) && $_POST['marca'] == 'apple' ? 'selected' : (isset($_GET['marca']) && $_GET['marca'] == 'apple' ? 'selected' : '') ?>>Apple</option>
                <option value="fitbit" <?= isset($_POST['marca']) && $_POST['marca'] == 'fitbit' ? 'selected' : (isset($_GET['marca']) && $_GET['marca'] == 'fitbit' ? 'selected' : '') ?>>FitBit</option>
                <option value="polar" <?= isset($_POST['marca']) && $_POST['marca'] == 'polar' ? 'selected' : (isset($_GET['marca']) && $_GET['marca'] == 'polar' ? 'selected' : '') ?>>Polar</option>
                <option value="samsung" <?= isset($_POST['marca']) && $_POST['marca'] == 'samsung' ? 'selected' : (isset($_GET['marca']) && $_GET['marca'] == 'samsung' ? 'selected' : '') ?>>Samsung</option>
                <option value="huawei" <?= isset($_POST['marca']) && $_POST['marca'] == 'huawei' ? 'selected' : (isset($_GET['marca']) && $_GET['marca'] == 'huawei' ? 'selected' : '') ?>>Huawei</option>
            </select>
            </li><br>
            <li><label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?= isset($_POST['modelo']) ? htmlspecialchars($_POST['modelo']) : (isset($_GET['modelo']) ? htmlspecialchars($_GET['modelo']) : '') ?>" required>
            </li><br>
            <li><label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?= isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : (isset($_GET['precio']) ? htmlspecialchars($_GET['precio']) : '') ?>" required>
            </li><br>
            <li><label for="detalles">Detalles:</label>
            <textarea name="detalles" value=""><?= isset($_POST['detalles']) ? htmlspecialchars($_POST['detalles']) : (isset($_GET['detalles']) ? htmlspecialchars($_GET['detalles']) : '') ?></textarea>
            </li><br>
            <li><label for="unidades">Unidades:</label>
            <input type="number" id="unidades" name="unidades" value="<?= isset($_POST['unidades']) ? htmlspecialchars($_POST['unidades']) : (isset($_GET['unidades']) ? htmlspecialchars($_GET['unidades']) : '') ?>" required>
            </li><br>
            <li><label for="imagen">Imagen:</label>
            <input type="text" id="imagen" name="imagen" value="<?= isset($_POST['imagen']) ? htmlspecialchars($_POST['imagen']) : (isset($_GET['imagen']) ? htmlspecialchars($_GET['imagen']) : '') ?>">
            </li><br>
            </ul>
        </fieldset>

        <script>
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
        } else {
            echo "Error: No se proporcionó el ID del producto.";
            exit;
        }
        </script>
        <input type="hidden" name="id" value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>" />

        <p>
            <input type="submit" value="Actualizar el producto">
        </p>
    </form>
</body>
</html>