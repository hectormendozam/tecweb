// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            conole.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    if (!validarJSON(finalJSON)) {
        return; // Detener el proceso si la validación falla
    }

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };
    client.send(productoJsonString);
}

function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL TÉRMINO A BUSCAR (puede ser parte del nombre, marca o detalles)
    var search = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);

            // LIMPIA LA TABLA ANTES DE AGREGAR NUEVOS RESULTADOS
            document.getElementById("productos").innerHTML = "";

            // SE VERIFICA SI EL OBJETO JSON TIENE PRODUCTOS
            if (productos.length > 0) {
                // RECORRE LOS PRODUCTOS Y CREA UNA FILA HTML PARA CADA UNO
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';

                    // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    document.getElementById("productos").innerHTML += template;
                });
            } else {
                // SI NO HAY RESULTADOS, SE MUESTRA UN MENSAJE
                document.getElementById("productos").innerHTML = "<tr><td colspan='3'>No se encontraron productos</td></tr>";
            }
        }
    };
    client.send("search=" + encodeURIComponent(search));
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

function validarJSON(finalJSON){
    if (!finalJSON.nombre || finalJSON.nombre.length == 0) {
    alert("El nombre del producto es obligatorio");
    return false;
    }
    if(!finalJSON.nombre.length > 100){
    alert("El nombre del producto no puede ser mayor a 100 caracteres");
    return false;
    }

    const marcasValidas = ["Samsung", "Apple", "Huawei", "Xiaomi", "Garmin", "Fitbit", "Polar"];
    if (!finalJSON.marca || finalJSON.marca.length == 0) {
    alert("La marca del producto es obligatoria");
    return false;
    }
    if (!marcasValidas.includes(finalJSON.marca)) {
        alert("La marca del producto no es válida");
        return false;
    }
    if (!finalJSON.precio || finalJSON.precio.length == 0) {
        alert("Ingrese el precio");
        return false;
    }
    if (isNaN(finalJSON.precio)) {
        alert("El precio debe ser un número");
        return false;
    }
    if (finalJSON.precio < 99.99) {
        alert("El precio no puede ser menor a $99.99");
        return false;
    }
    if(finalJSON.unidades == null || finalJSON.unidades < 0){
        alert("La cantidad mínima de unidades es 0");
        return false;
    }
    if (finalJSON.imagen || finalJSON.imagen.length == 0) {
        finalJSON.imagen = "img/default.png";
    }
    if (finalJSON.modelo || finalJSON.modelo.length == 0) {
        alert("El modelo del producto es obligatorio");
        return false;
    }
    if (!/^[a-zA-Z0-9]{1,25}$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
        alert("El modelo debe ser alfanumérico y menor a 25 caracteres");
        return false;
    }
    if (finalJSON.detalles || finalJSON.detalles.length > 250) {
        alert("Los detalles no pueden ser mayores a 250 caracteres");
        return false;
    }

    return true;
}