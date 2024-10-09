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

function datosBasicos(){
    var nombre = 'Juan';
    var edad = 10
    ;
    var altura = 1.92
    ;
    var casado = false
    ;

    document.write( nombre );
    document.write( '<br>' );
    document.write( edad );
    document.write( '<br>' );
    document.write( altura );
    document.write( '<br>' );
    document.write( casado );
}

function ingresarDatos(){
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad:', '');
    document.write('Hola ');
    document.write(nombre);
    document.write(' así que tienes ');
    document.write(edad);
    document.write(' años');
    }