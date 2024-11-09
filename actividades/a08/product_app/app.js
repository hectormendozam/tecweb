// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};


function validarNombre(nombre) {
    /*if (!nombre || nombre.trim() === "") {
        return "El nombre es requerido.";
    }*/
    if (nombre.length > 100) {
        return "El nombre no debe tener más de 100 caracteres.";
    }
    return "Nombre válido.";
}

function validarMarca(marca, opcionesValidas) {

    if (!opcionesValidas.includes(marca)) {
        return "La marca seleccionada no es válida.";
    }
    return "Marca válida.";
}

function validarModelo(modelo) {
    const alfanumericoRegex = /^[a-zA-Z0-9\s]+$/; // Permite letras, números y espacios
    
    if (!alfanumericoRegex.test(modelo)) {
        return "El modelo debe ser alfanumérico.";
    }
    if (modelo.length > 25) {
        return "El modelo no debe tener más de 25 caracteres.";
    }
    return "Modelo válido.";
}

function validarPrecio(precio) {
    if (isNaN(precio)) {
        return "El precio debe ser un número válido.";
    }
    if (parseFloat(precio) <= 99.99) {
        return "El precio debe ser mayor a 99.99.";
    }
    // Verifica que el precio tenga como máximo 2 decimales
    const dosDecimales = /^\d+(\.\d{1,2})?$/;
    if (!dosDecimales.test(precio)) {
        return "El precio debe tener como máximo 2 decimales.";
    }
    return "Precio válido.";
}

function validarDetalles(detalles) {
    if (detalles.length > 250) {
        return "Los detalles no deben tener más de 250 caracteres.";
    }
    return "Detalles válidos.";
}

function validarUnidades(unidades) {
    if (isNaN(unidades) || parseInt(unidades) < 0) {
        return "Las unidades deben ser un número mayor o igual a 0.";
    }
    return "Unidades válidas.";
}

function validarImagen(rutaImagen) {
    const rutaPorDefecto = "C:/xampp/htdocs/tecweb/defecto.jpg";  // Aquí defines la ruta por defecto

    if (!rutaImagen || rutaImagen.trim() === "") {
        return rutaPorDefecto;  // Si la ruta de imagen no se proporciona, usa la ruta por defecto
    }
    return rutaImagen;  // Si se proporciona una ruta válida, usa la ruta proporcionada
}

function validarFormulario(event) {
    event.preventDefault(); // Evitar el envío del formulario

    const nombre = document.getElementById('nombre').value;
    const marca = document.getElementById('marcas').value;
    const modelo = document.getElementById('modelo').value;
    const precio = document.getElementById('precio').value;
    const detalles = document.getElementById('detalles').value;
    const unidades = document.getElementById('unidades').value;
    const imagen = document.getElementById('imagen').value;

    const opcionesValidas = ["garmin", "apple", "fitbit", "polar", "samsung", "huawei"];
    const errores = [];

    // Validar cada campo y agregar errores si los hay
    errores.push(validarNombre(nombre));
    errores.push(validarMarca(marca, opcionesValidas));
    errores.push(validarModelo(modelo));
    errores.push(validarPrecio(precio));
    errores.push(validarDetalles(detalles));
    errores.push(validarUnidades(unidades));
    const imagenValida = validarImagen(imagen);
    if (imagenValida !== "ruta/a/imagen/por/defecto.jpg") {
        //errores.push(imagenValida);
    }

    // Filtrar errores vacíos y mostrar resultados
    const erroresFiltrados = errores.filter(error => error !== "Nombre válido." && 
                                                    error !== "Marca válida." && 
                                                    error !== "Modelo válido." && 
                                                    error !== "Precio válido." && 
                                                    error !== "Detalles válidos." && 
                                                    error !== "Unidades válidas.");

    if (erroresFiltrados.length > 0) {
        alert(erroresFiltrados.join('\n')); // Muestra los errores en una alerta
    } else {
        alert("Formulario enviado correctamente!"); // Mensaje de éxito
        // Aquí puedes enviar el formulario si es necesario
        // document.getElementById('productoForm').submit();
    }
}

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON,null,2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        let postData = JSON.parse( $('#description').val() );
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        /**
         * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
         * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
         **/

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            //console.log(response);
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let respuesta = JSON.parse(response);
            // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
            // SE REINICIA EL FORMULARIO
            $('#name').val('');
            $('#description').val(JsonString);
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').show();
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
            // SE REGRESA LA BANDERA DE EDICIÓN A false
            edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id);
            // SE ELIMINA nombre, eliminado E id PARA PODER MOSTRAR EL JSON EN EL <textarea>
            delete(product.nombre);
            delete(product.eliminado);
            delete(product.id);
            // SE CONVIERTE EL OBJETO JSON EN STRING
            let JsonString = JSON.stringify(product,null,2);
            // SE MUESTRA STRING EN EL <textarea>
            $('#description').val(JsonString);
            
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
        });
        e.preventDefault();
    });
    
    $('#name').on('keyup', function() {
        const nombre = $(this).val();
        if (nombre.trim() !== "") {
            $.ajax({
                url: './backend/product-search.php',
                type: 'POST',
                data: { accion: 'validarNombre', nombre },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.length > 0 && result[0].count > 0) {
                        $('#container').html('<li>El nombre del producto ya existe.</li>');
                    } else {
                        $('#container').html('<li>Nombre válido.</li>');
                    }
                }
            });
        }
    });
    
});