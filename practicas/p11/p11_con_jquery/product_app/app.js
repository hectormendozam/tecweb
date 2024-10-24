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
    listadoProductos();

    function listadoProductos(){
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response){
                let productos = JSON.parse(response);
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

    $(document).on('click', '.product-delete', function() {
        if( confirm("De verdad deseas eliminar el Producto") ) {
            var id = event.target.parentElement.parentElement.getAttribute("productId");
            $.ajax({
                url: './backend/product-delete.php?id='+id,
                type: 'GET',
                data: {id},

                success: function(response){
                    let respuesta = JSON.parse(response);
                    let template_bar = '';
                    template_bar += `
                                <li style="list-style: none;">status: ${respuesta.status}</li>
                                <li style="list-style: none;">message: ${respuesta.message}</li>
                            `;
                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;

                    listadoProductos();
                }
            });
        }
    });

    $(document).on('click', '.product-item', function() {
        let id = $(this)[0].parentElement.parentElement.getAttribute('productid');
        $.post('./backend/product-single.php', {id}, function(response){
            const product = JSON.parse(response);
            $('#name').val(product[0].nombre);
            $('#productId').val(product[0].id);
            let productWithoutNameAndId = {...product[0]};
            delete productWithoutNameAndId.nombre;
            delete productWithoutNameAndId.id;
            delete productWithoutNameAndId.eliminado;

            $('#description').val(JSON.stringify(productWithoutNameAndId, null, 4));
            edit = true;

            $('#submit-button').text('Editar Producto');

        })
    });
});