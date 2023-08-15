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

function setTitulares(listajugadores){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Convertir el objeto en una cadena JSON
    var listaJugadoresJSON = JSON.stringify(listajugadores);

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            if (this.responseText) {
                // La respuesta ha sido recibida
                console.log("La respuesta está completa.");
            } else {
                console.log("La respuesta está vacía o incompleta.");
            }
        }
    };

    // Hacer la solicitud AJAX POST
    xhttp.open("POST", "setTitulares.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(listaJugadoresJSON);
}

