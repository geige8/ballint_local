function mostrarVentanaCambioPass(formulario) {

    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);
    // Crea la ventana emergente
    var ventana = document.createElement("div");
    ventana.setAttribute("id", "ventana");
    
    // Agrega un formulario para cambiar la contraseña

    ventana.innerHTML = formulario;
    
    // Agrega la ventana emergente al cuerpo de la página
    document.body.appendChild(ventana);

    ventana.classList.add("mostrar");

    // Crear el botón de cerrar y agregar el controlador de eventos
    var cerrar = document.createElement('button');
    cerrar.classList.add('cerrar');
    cerrar.innerHTML = 'X';
    ventana.appendChild(cerrar);

    cerrar.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
        ventana.parentNode.removeChild(ventana);
        overlay.parentNode.removeChild(overlay);
    });
}


// Creamos la función que muestra la ventana emergente
function ventanaSeleccionJugador(formulario) {
    console.log('ventanaSeleccionJugador llamada');

    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Crear la ventana emergente
    var ventana = document.createElement("div");
    ventana.setAttribute("id", "ventana2");

    // Agregar el formulario a la ventana emergente
    ventana.innerHTML = formulario;

    // Agregar la ventana emergente al cuerpo de la página
    document.body.appendChild(ventana);

    // Mostrar la ventana emergente
    ventana.classList.add("mostrar");

    // Crear el botón de cerrar y agregar el controlador de eventos
    var cerrar = document.createElement('button');
    cerrar.classList.add('cerrar');
    cerrar.innerHTML = 'X';
    ventana.appendChild(cerrar);

    cerrar.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
        ventana.parentNode.removeChild(ventana);
        overlay.parentNode.removeChild(overlay);
    });
}