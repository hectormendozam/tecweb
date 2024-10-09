function getDatos(){
    var nombre = prompt('Ingrese su nombre: ', '');
    var edad = prompt('Ingrese su edad: ', 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3>Nombre: ' + nombre + '</h3>';
    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3>Edad: ' + edad + '</h3>';
}

function holaMundo(){
    document.write('Hola Mundo');
}