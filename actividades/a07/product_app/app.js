// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/imagen.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

$(document).ready(function() {

    let edit = false;

    console.log('JQuery está trabajando!')

    function listadoProductos(){
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response){
                console.log(response);
                let productos = JSON.parse(response);
                console.log(productos);
                if(Object.keys(productos).length > 0) {
                    let template = '';

                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>
                                    <a href="#" class="product-item">${producto.nombre}</a>
                                </td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById("products").innerHTML = template;
                }
            }
        });
    }

    listadoProductos();

    $('#search').keyup(function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

        // Obtener el valor de búsqueda usando jQuery
        var search = $('#search').val(); // Cambia 'searchInput' por el ID correcto del campo de entrada

        // Realizar la solicitud AJAX
        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                let productos = JSON.parse(response);

                if (Object.keys(productos).length > 0) {
                    let template = '';
                    let template_bar = '';

                    productos.forEach(producto => {
                        let descripcion = `
                            <li>precio: ${producto.precio}</li>
                            <li>unidades: ${producto.unidades}</li>
                            <li>modelo: ${producto.modelo}</li>
                            <li>marca: ${producto.marca}</li>
                            <li>detalles: ${producto.detalles}</li>
                        `;

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>
                                    <a href="#" class="product-item">${producto.nombre}</a>
                                </td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" data-id="${producto.id}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;

                        template_bar += `<li>${producto.nombre}</li>`;
                    });

                    // Actualizar el DOM con los resultados
                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;
                    document.getElementById("products").innerHTML = template;
                } else {
                    // Manejar el caso en que no se encuentran productos
                    document.getElementById("product-result").className = "card my-4 d-none"; // Ocultar el contenedor
                    document.getElementById("container").innerHTML = ""; // Limpiar la barra de estado
                    document.getElementById("products").innerHTML = ""; // Limpiar la tabla de productos
                }
            },
            error: function() {
                alert("Hubo un error al realizar la búsqueda.");
            }
        });
    });

    $('#product-form').submit(function(e) {
        e.preventDefault();
        var productoJsonString = document.getElementById('description').value;
        var finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = document.getElementById('name').value;
        finalJSON['id'] = document.getElementById('productId').value;
        productoJsonString = JSON.stringify(finalJSON, null, 3);

        let template_bar = '';
        let errores = [];

        // Validar nombre
        if (!finalJSON.nombre || finalJSON.nombre.length == 0) {
            errores.push('Ingresa un nombre.');
        }
        if (finalJSON.nombre.length > 100) {
            errores.push('El nombre debe tener menos de 100 caracteres.');
        }

        // Validar marca
        const marcasValidas = ['Garmin', 'Polar', 'Casio', 'Apple', 'Samsung', 'Xiaomi', 'Huawei', 'Fitbit'];
        if (!finalJSON.marca || finalJSON.marca.length == 0) {
            errores.push('Selecciona una marca válida.');
        }
        if (!marcasValidas.includes(finalJSON.marca)) {
            errores.push('Marca no válida.');
        }

        // Validar modelo
        if (!finalJSON.modelo || finalJSON.modelo.length == 0) {
            errores.push('Ingresa un modelo.');
        }
        if (!/^[a-zA-Z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
            errores.push('El modelo debe ser alfanumérico y menor a 25 caracteres.');
        }

        // Validar precio
        if (!finalJSON.precio || finalJSON.precio.length == 0) {
            errores.push('Ingresa el precio.');
        }
        if (finalJSON.precio < 99.99) {
            errores.push('El precio debe ser mayor a $99.99.');
        }

        // Validar detalles
        if (finalJSON.detalles && finalJSON.detalles.length > 250) {
            errores.push('Los detalles deben tener máximo 250 caracteres.');
        }

        // Validar unidades
        if (finalJSON.unidades == null || finalJSON.unidades < 0) {
            errores.push('La cantidad mínima de unidades es 0.');
        }

        // Validar imagen
        if (!finalJSON.imagen || finalJSON.imagen.length == 0) {
            finalJSON.imagen = 'img/pre.png';  // Asignar una imagen por defecto
        }

        // Si hay errores, mostrarlos todos
        if (errores.length > 0) {
            template_bar = '<ul>';
            template_bar+= '<li style="list-style: none;">status: Error</li>';
            errores.forEach(error => {
                template_bar += `<li style="list-style: none;">message: ${error}</li>`;
            });
            template_bar += '</ul>';

            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;
        }

        else{
            let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
            console.log(finalJSON);

            $.ajax({
                url: url,
                type: 'POST',
                contentType: 'application/json', // Especificar que estamos enviando JSON
                data: JSON.stringify(finalJSON),

                success: function(response) {
                    console.log(response);
                    let respuesta = JSON.parse(response);
                    let template_bar = '';
                    template_bar += `
                                <li style="list-style: none;">status: ${respuesta.status}</li>
                                <li style="list-style: none;">message: ${respuesta.message}</li>
                            `;

                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;

                    listadoProductos();
                    init();
                    edit = false;
                    $('#submit-button').text('Agregar Producto');
                    $('#name').val('');
                }
            });
        }
    });

    $(document).on('click', '.product-delete', function(){
        let row = $(this)[0].parentElement.parentElement;

        if(confirm('¿De verdad quieres eliminar este producto?')){
            let id = $(row).attr('productId');
            $.post('backend/product-delete.php', {id}, function(response){
                let serverResponse = JSON.parse(response);
                console.log(serverResponse);
                if(serverResponse['status'] === 'error'){
                    template_bar = '';
                    template_bar += `
                                <li style="list-style: none;">status: ${serverResponse.status}</li>
                                <li style="list-style: none;">message: ${serverResponse.message}</li>
                                `;
                }
                else{
                    template_bar = '';
                    template_bar += `
                                <li style="list-style: none;">status: ${serverResponse.status}</li>
                                <li style="list-style: none;">message: ${serverResponse.message}</li>
                                `;
                    listadoProductos();
                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;
                    
                }
                
            });
        }
    });

    $(document).on('click', '.product-item', function() {
        let row = $(this)[0].parentElement.parentElement;
        let id = $(row).attr('productid');
        $.post('backend/product-single.php', {id}, function(response){
            edit = true;
            let product = JSON.parse(response);

            $('#productId').val(product['id']);
            $('#name').val(product['nombre']);

            delete product.id;
            delete product.nombre;
            let description = JSON.stringify(product, null, 2);
            $('#description').val(description);
            $('#botonFormulario').html(edit === false ? 'Agregar producto' : 'Editar producto');

        })
    });
});