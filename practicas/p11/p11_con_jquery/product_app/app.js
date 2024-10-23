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
                                <td>${producto.nombre}</td>
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
        productoJsonString = JSON.stringify(finalJSON, null, 2);

        // Validar nombre de producto
        if (!finalJSON.nombre || finalJSON.nombre.length == 0) {
            alert('Ingresa un nombre');
            return false;
        }
        if (finalJSON.nombre.length > 100) {
            alert('El nombre debe tener máximo 100 caracteres');
            return false;
        }

        // Validar marca de producto
        const marcasValidas = ['Garmin', 'Samsung', 'Apple', 'Huawei', 'FitBit', 'Xiaomi', 'Polar'];
        if (!finalJSON.marca || finalJSON.marca.length == 0) {
            alert('Selecciona una marca');
            return false;
        }
        if (!marcasValidas.includes(finalJSON.marca)) {
            alert('Marca no válida, selecciona una válida (Gamrin, Samsung, Apple, Huawei, FitBit, Xiaomi, Polar)');
            return false;
        }

        // Validar modelo de producto
        if (!finalJSON.modelo || finalJSON.modelo.length == 0) {
            alert('Ingresa un modelo');
            return false;
        }
        if (!/^[a-zA-Z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
            alert('El modelo debe ser alfanumérico y menor a 25 caracteres');
            return false;
        }

        // Validar precio de producto
        if (!finalJSON.precio || finalJSON.precio.length == 0) {
            alert('Ingresa el precio');
            return false;
        }
        if (finalJSON.precio < 99.99) {
            alert('El precio debe ser mayor a $99.99');
            return false;
        }

        // Validar detalles de producto
        if (finalJSON.detalles && finalJSON.detalles.length > 250) {
            alert('Los detalles deben tener máximo 250 caracteres');
            return false;
        }

        // Validar unidades de producto
        if (finalJSON.unidades == null || finalJSON.unidades < 0) {
            alert('Cantidad mínima de unidades es 0');
            return false;
        }

        // Validar imagen de producto
        if (!finalJSON.imagen || finalJSON.imagen.length == 0) {
            finalJSON.imagen = 'img/pre.png';  // Asignar una imagen por defecto
        }

        let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

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
    });

    $(document).on('click', '.product-delete', function() {
        if( confirm("¿De verdad deseas eliminar este producto?") ) {
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