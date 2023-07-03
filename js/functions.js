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



function seleccionQuintetoInicial(local,visitante,jugadoresLocal,jugadoresVisitante){

    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement("div");
    ventana.classList.add("ventana-quintetos");
    document.body.appendChild(ventana);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var titulares = document.createElement("h1");
    titulares.textContent = `Selecciona los titulares de ambos equipos`;
    ventana.appendChild(titulares);



    // Crear los contenedores de lista para los jugadores locales y visitantes
    var contenedorListas = document.createElement('div');
    contenedorListas.classList.add('contenedor-listas');
    ventana.appendChild(contenedorListas);

    // Crear los contenedores de lista para los jugadores locales y visitantes
    var contenedorLocal = document.createElement('div');
    contenedorLocal.classList.add('contenedor-jugadores');
    contenedorListas.appendChild(contenedorLocal);

    var contenedorVisitante = document.createElement('div');
    contenedorVisitante.classList.add('contenedor-jugadores');
    contenedorListas.appendChild(contenedorVisitante);

    var p = document.createElement("p");
    p.textContent = `Equipo: ${local}`;
    contenedorLocal.appendChild(p);

    var p = document.createElement("p");
    p.textContent = `Equipo: ${visitante}`;
    contenedorVisitante.appendChild(p);
    
    // Crear las listas de jugadores y agregarlos a los contenedores
    var listaLocal = document.createElement('ul');
    listaLocal.classList.add('lista-jugadores');
    contenedorLocal.appendChild(listaLocal);

    var listaVisitante = document.createElement('ul');
    listaVisitante.classList.add('lista-jugadores');
    contenedorVisitante.appendChild(listaVisitante);
    
    // Agregar los jugadores a cada lista
    jugadoresLocal.forEach(function(jugador) {
        var li = document.createElement('li');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        li.appendChild(checkbox);
        li.appendChild(document.createTextNode(jugador['numero']+' - '+jugador['jugador']+' - '+jugador['nombrejugador']));
        listaLocal.appendChild(li);
    });

    jugadoresVisitante.forEach(function(jugador) {
        var li = document.createElement('li');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        li.appendChild(checkbox);
        li.appendChild(document.createTextNode(jugador['numero']+' - '+jugador['jugador']+' - '+jugador['nombrejugador']));
        listaVisitante.appendChild(li);
    });
 

    // Crear el botón de confirmar y agregar el controlador de eventos
    var confirmar = document.createElement('button');
    confirmar.classList.add('confirmar');
    confirmar.innerHTML = 'Confirmar';
    ventana.appendChild(confirmar);
 
    confirmar.addEventListener('click', function() {
        // Obtener los jugadores seleccionados
        var jugadoresSeleccionados = [];
        var checkboxesSeleccionados = document.querySelectorAll('input[type="checkbox"]:checked');
        checkboxesSeleccionados.forEach(function(checkbox) {
            var jugador = checkbox.parentNode.textContent.split(' - ');
            jugadoresSeleccionados.push({numero: jugador[0], jugador: jugador[1]});
        });
        // Validar que se hayan seleccionado 5 jugadores locales y 5 visitantes
        var cantidadLocal = document.querySelectorAll('.contenedor-jugadores:nth-child(1) input[type="checkbox"]:checked').length;
        var cantidadVisitante = document.querySelectorAll('.contenedor-jugadores:nth-child(2) input[type="checkbox"]:checked').length;
        if (cantidadLocal === 5 && cantidadVisitante === 5) {
            console.log(jugadoresSeleccionados);
            // Llamar a una función con los jugadores seleccionados
            setTitulares(jugadoresSeleccionados);
            getJugadoresPista();
            
            // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        } else {
            alert('Por favor, seleccione 5 jugadores locales y 5 visitantes antes de confirmar.');
        }
    });

    // Mostrar la ventana emergente
    ventana.classList.add("mostrar");
}