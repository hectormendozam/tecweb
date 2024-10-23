// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        method: 'GET',
        dataType: 'json',
        success: function(productos) {
            if (productos.length > 0) {
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
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto(${producto.id})">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    template_bar += `<li>${producto.nombre}</li>`;
                });

                $("#products").html(template);
                $("#container").html(template_bar);
                $("#product-result").addClass("d-block"); // Mostrar barra de estado
            }
        }
    });
}

