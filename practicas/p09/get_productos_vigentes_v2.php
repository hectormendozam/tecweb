<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<?php
		header("Content-Type: text/html; charset=UTF-8"); 
		$data = array();

			/** SE CREA EL OBJETO DE CONEXION */
			@$link = new mysqli('localhost', 'root', '12345678', 'marketzone');
			/** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

			/** comprobar la conexión */
			if ($link->connect_errno) 
			{
				die('Falló la conexión: '.$link->connect_error.'<br/>');
				//exit();
			}

			/** Crear una tabla que no devuelve un conjunto de resultados */
			if ( $result = $link->query("SELECT * FROM productos WHERE eliminado = 0") ) 
			{
				/** Se extraen las tuplas obtenidas de la consulta */
				$row = $result->fetch_all(MYSQLI_ASSOC);

				/** Se crea un arreglo con la estructura deseada */
				foreach($row as $num => $registro) {            // Se recorren tuplas
					foreach($registro as $key => $value) {      // Se recorren campos
						$data[$num][$key] = utf8_encode($value);
					}
				}

				$result->free();
			}

			$link->close();
		
	?>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script>
		function show() {
                // se obtiene el id de la fila donde está el botón presinado
                var rowId = event.target.parentNode.parentNode.id;
				console.log("rowId: ", rowId);

                // se obtienen los datos de la fila en forma de arreglo
                // Verifica si existe el elemento con este ID
				var rowElement = document.getElementById(rowId);
				if (!rowElement) {
					console.error("Elemento con id " + rowId + " no encontrado.");
					return;
				}

				var data = rowElement.querySelectorAll(".row-data");
				if (data.length === 0) {
					console.error("No se encontraron elementos con la clase 'row-data' en la fila.");
					return;
				};
				
                /**
                querySelectorAll() devuelve una lista de elementos (NodeList) que 
                coinciden con el grupo de selectores CSS indicados.
                (ver: https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors)

                En este caso se obtienen todos los datos de la fila con el id encontrado
                y que pertenecen a la clase "row-data".
                */

                var name = data[0].innerHTML;
                var brand = data[1].innerHTML;
				var model = data[2].innerHTML;
                var price = data[3].innerHTML;
				var units = data[4].innerHTML;
                var details = data[5].innerHTML;
				var image = data[6].firstChild.getAttribute('src');
				var id = rowId;

                alert("Nombre: " + name + "\nMarca: " + brand+ "\nModelo: " + model+ "\nPrecio: " + price+ "\nUnidades: " + units+ "\nDetalles: " + details+ "\nImagen: " + image);

                send2form(name, brand, model, price, units, details, image, id);
            }

		function send2form(name, brand, model, price, units, details, image, id) {
                var form = document.createElement("form");

                var nombreIn = document.createElement("input");
                nombreIn.type = 'text';
                nombreIn.name = 'nombre';
                nombreIn.value = name;
                form.appendChild(nombreIn);

                var marcaIn = document.createElement("input");
                marcaIn.type = 'text';
                marcaIn.name = 'marca';
                marcaIn.value = brand;
                form.appendChild(marcaIn);

				var modeloIn = document.createElement("input");
				modeloIn.type = 'text';
				modeloIn.name = 'modelo';
				modeloIn.value = model;
				form.appendChild(modeloIn);

				var precioIn = document.createElement("input");
				precioIn.type = 'number';
				precioIn.name = 'precio';
				precioIn.value = price;
				form.appendChild(precioIn);

				var unidadesIn = document.createElement("input");
				unidadesIn.type = 'number';
				unidadesIn.name = 'unidades';
				unidadesIn.value = units;
				form.appendChild(unidadesIn);

				var detallesIn = document.createElement("input");
				detallesIn.type = 'text';
				detallesIn.name = 'detalles';
				detallesIn.value = details;
				form.appendChild(detallesIn);

				var imagenIn = document.createElement("input");
				imagenIn.type = 'text';
				imagenIn.name = 'imagen';
				imagenIn.value = image;
				form.appendChild(imagenIn);

				var idIn = document.createElement("input");
				idIn.type = 'number';
				idIn.name = 'id';
				idIn.value = id;
				form.appendChild(idIn);

                console.log(form);

                form.method = 'POST';
                form.action = 'http://localhost/tecweb/practicas/p09/formulario_productos_v2.php';  

                document.body.appendChild(form);
                form.submit();
            }
	</script>
	</head>
	<body>
		<h3>PRODUCTO</h3>
		
		<br/>
				
			<?php if( isset($row) ) : ?>
		
				<table class="table">
				<thead class="thead-dark">
					<tr>
					<th scope="col">#</th>
					<th scope="col">Nombre</th>
					<th scope="col">Marca</th>
					<th scope="col">Modelo</th>
					<th scope="col">Precio</th>
					<th scope="col">Unidades</th>
					<th scope="col">Detalles</th>
					<th scope="col">Imagen</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($row as $registro) : ?>
					<tr id=<?= $registro['id'] ?>>
						<th scope="row"><?= $registro['id'] ?></th>
						<td class="row-data"><?= $registro['nombre'] ?></td>
						<td class="row-data"><?= $registro['marca'] ?></td>
						<td class="row-data"><?= $registro['modelo'] ?></td>
						<td class="row-data"><?= $registro['precio'] ?></td>
						<td class="row-data"><?= $registro['unidades'] ?></td>
						<td class="row-data"><?= utf8_encode($registro['detalles']) ?></td>
						<td class="row-data"><img src=<?= $registro['imagen'] ?> ></td>
						<td><input type="button" value="Actualizar" onclick="show()" /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		
		<?php elseif(!empty($id)) : ?>
		
			<script>
				alert('El ID del producto no existe');
			</script>

		<?php endif; ?>
	</body>
</html>
		