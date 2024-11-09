// JSON BASE A MOSTRAR EN FORMULARIO
/*var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};*/

$(document).ready(function(){
    let edit = false;

    /*let JsonString = JSON.stringify(baseJSON,null,2);
    $('#description').val(JsonString);*/
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

        var datosProducto = {
            id: $('#productId').val(),
            nombre: $('#nombre').val(),
            marca: $('#marcas').val(),
            modelo: $('#modelo').val(),
            precio: $('#precio').val(),
            detalles: $('#detalles').val(),
            unidades: $('#unidades').val(),
            imagen: $('#imagen').val()
        };

        var productoJsonString = JSON.stringify(datosProducto, null, 3);

        datosProducto['nombre'] = document.getElementById('name').value;
        datosProducto['id'] = document.getElementById('productId').value;

        productoJsonString = JSON.stringify(datosProducto, null, 3);

        var finalJSON = JSON.parse(productoJsonString);
        productoJsonString = JSON.stringify(finalJSON, null, 3);

        let template_bar = '';
        let errores = [];
        let correcto =[];

        if (!finalJSON.nombre || finalJSON.nombre.length == 0) {
            errores.push('Ingresa un nombre.');
        }
        else if (finalJSON.nombre.length > 100) {
            errores.push('El nombre debe tener menos de 100 caracteres.');
        }
        else {
            correcto.push('Nombre válido')
        }

        const marcasValidas = ['Nintendo', 'Xbox', 'Playstation'];
        if (!finalJSON.marca || finalJSON.marca.length == 0) {
            errores.push('Selecciona una marca.');
        }
        else if (!marcasValidas.includes(finalJSON.marca)) {
            errores.push('Marca no válida.');
        }
        else {
            correcto.push('Marca válida.')
        }

        if (!finalJSON.modelo || finalJSON.modelo.length == 0) {
            errores.push('Ingresa un modelo.');
        }
        else if (!/^[a-zA-Z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
            errores.push('El modelo debe ser alfanumérico y menor a 25 caracteres.');
        }
        else {
            correcto.push('Modelo válido.')
        }

        if (!finalJSON.precio || finalJSON.precio.length == 0) {
            errores.push('Ingresa el precio.');
        }
        else if (finalJSON.precio < 99.99) {
            errores.push('El precio debe ser mayor a $99.99.');
        }
        else {
            correcto.push('Precio válido.')
        }

        if (finalJSON.detalles && finalJSON.detalles.length > 250) {
            errores.push('Los detalles deben tener máximo 250 caracteres.');
        }

        if (finalJSON.unidades == null || finalJSON.unidades < 0) {
            errores.push('La cantidad mínima de unidades es 0.');
        }
        else if (finalJSON.unidades<1) {
            errores.push('El campo unidades es obligatorio');
        }
        else if (finalJSON.unidades>0){
            correcto.push('Unidades válidas')
        }

        if (!finalJSON.imagen || finalJSON.imagen.length == 0) {
            finalJSON.imagen = 'img/pre.png';  // Asignar una imagen por defecto
        }

        if (correcto.length > 1) {
            template_bar = '<ul>';
            template_bar+= '<li style="list-style: none;">status: Success</li>';
            correcto.forEach(bien => {
                template_bar += `<li style="list-style: none;">message: ${bien}</li>`;
            });
            template_bar += '</ul>';

            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;
        }

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
            $('#submit-button').text('Agregar Producto');
            $('#form-name').val('');
            $('#form-brand').val('');
            $('#form-model').val('');
            $('#form-price').val('');
            $('#form-story').val('');
            $('#form-units').val('');
            $('#form-img').val('');
            $('#productId').val('');
        });
        }
    });


    $(document).on('click', '.product-delete', function() {
        if( confirm("¿Realmente quieres eliminar este producto?") ) {
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
    
    $('#form-name').keyup(function(e) {
        e.preventDefault();

        var name = $('#form-name').val();

        $.ajax({
            url: './backend/product-singleByName.php',
            type: 'GET',
            data: { name: name },
            success: function(response) {
                let productos = response;
                if(productos.length > 2) {
                    let template_bar = '';
                    template_bar+= '<li style="list-style: none;">status: Error</li>';
                    template_bar += `<li style="list-style: none;">Ya existe este producto</li>`;
                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;
                }
                else{
                    let template_bar = '';
                    template_bar+= '<li style="list-style: none;">status: Success</li>';
                    template_bar += `<li style="list-style: none;">Nombre de producto válido</li>`;
                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;
                }
            }

        });
    });
});

let template_bar = '';
template_bar = '<ul>';
template_bar+= '<li style="list-style: none;">status: Error</li>';

function validarNombre(){
    var nombre = document.getElementById("name");
    if(nombre.value == ''){
        template_bar += `<li style="list-style: none;">El campo nombre es obligatorio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
    else if (nombre.value.length > 100){
        template_bar += `<li style="list-style: none;">El nombre debe tener como maximo 100 caracteres</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;

    }
}

function validarMarca(){
    var marca = document.getElementById("marcas");
    if (marca.value == ""){
        template_bar += `<li style="list-style: none;">El campo marca es obligatorio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarModelo(){
    var modelo = document.getElementById("modelo");
    if (modelo.value == ''){
        template_bar += `<li style="list-style: none;">Ingresa un modelo</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarPrecio(){
    var precio = document.getElementById("precio");
    if (precio.value == ''){
        template_bar += `<li style="list-style: none;">Ingresa el precio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
    else if (precio.value <= 99.99){
        template_bar += `<li style="list-style: none;">El precio debe ser mayor a $99.99</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarDetalles(){
    var detalles = document.getElementById("detalles");
    if(detalles.value > 250)
    {
        template_bar += `<li style="list-style: none;">Los detalles deben tener máximo 250 caracteres</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarUnidades(){
    var unidades = document.getElementById("unidades");
    if (unidades.value == ''){
        template_bar += `<li style="list-style: none;">El campo unidades es obligatorio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
    else if (unidades.value < 0){
        template_bar += `<li style="list-style: none;">Cantidad mínima de unidades es 0</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarImagen(){
    var imagen = document.getElementById("imagen");
    if (imagen.value == ''){
        template_bar += `<li style="list-style: none;">Se asignó una imagen por defecto</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;

        imagen.value = "img/default.png";
    }
}