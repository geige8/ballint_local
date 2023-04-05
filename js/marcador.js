let period = document.getElementById("periodSelect").value;
let duration = document.getElementById("durationSelect").value;

//RELOJ CRONOMETRO
let [seconds, minutes] = [0, 10];
let timeRef = document.querySelector(".timer-display");
let int = null;

document.getElementById("durationSelect").addEventListener("change", () => {
    
    // Obtener el valor seleccionado del select
    duration = document.getElementById("durationSelect").value;

    // Actualizar los minutos del cronómetro
    minutes = parseInt(duration);
    seconds = 0;
});

document.getElementById("start-timer").addEventListener("click", () => {
    
    if(int !== null) {
        clearInterval(int);
    }

    int = setInterval(displayTimer, 1000);
});

document.getElementById("pause-timer").addEventListener("click", () => {
    clearInterval(int);
});

document.getElementById("reset-timer").addEventListener("click", () => {

    period = document.getElementById("periodSelect").value;

    clearInterval(int);

    duration = document.getElementById("durationSelect").value;

    // Actualizar los minutos del cronómetro
    minutes = parseInt(duration);
    seconds = 0;

    let m = minutes < 10 ? "0" + minutes : minutes;
    let s = seconds < 10 ? "0" + seconds : seconds;

    timeRef.innerHTML = `${m} : ${s}`;
}); 

function displayTimer() {
    
    if(seconds <= 0) {
        minutes--;
        seconds = 60;
    }

    seconds -= 1;

    let m = minutes < 10 ? "0" + minutes : minutes;
    let s = seconds < 10 ? "0" + seconds : seconds;

    timeRef.innerHTML = `${m} : ${s}`;

    if (minutes === 0 && seconds === 0) {
        clearInterval(int);
        timeRef.innerHTML = "Tiempo finalizado";
    }

}


////////////////////////////////////////////////////////////

let infoRef = document.querySelector(".info-display");
let logline = '';

function mostrarlogline(mensaje){
    period = document.getElementById("periodSelect").value;
    logline = `¡${mensaje}! --> ${period}, Time: ${minutes}:${seconds} , H:${pointsLocal.textContent} - V:${pointsVisit.textContent}; `;
    infoRef.innerHTML += logline ;
}


    //Tiempos Muertos
let timeoutLocal = document.querySelector(".timeout-local .timeout");
let timeoutVisit = document.querySelector(".timeout-visit .timeout");
let addTimeoutButtons = document.querySelectorAll(".add-timeout");

addTimeoutButtons.forEach(button => {
    button.addEventListener("click", () => {

        let timeout = parseInt(button.dataset.timeout);
        let timeoutContainer = button.parentNode.querySelector(".timeout");
        console.log(button.parentNode);

        timeoutContainer.textContent = parseInt(timeoutContainer.textContent) + timeout;

        if(button.parentNode == document.querySelector(".timeout-local")){
            mostrarlogline("Tiempo Muerto de locales");
        }
        else{
            mostrarlogline("Tiempo Muerto de visitantes");
        }
    });
});




//MARCADOR DE PUNTOS

let pointsLocal = document.querySelector(".points-local .points");
let pointsVisit = document.querySelector(".points-visit .points");
let addPointsButtons = document.querySelectorAll(".add-points");

addPointsButtons.forEach(button => {
    button.addEventListener("click", () => {
        
        let points = parseInt(button.dataset.points);
        let pointsContainer = button.parentNode.querySelector(".points");

        // Abre el cuadro de diálogo modal correspondiente

        if(button.parentNode == document.querySelector(".points-local")){
            openPlayerDialogLocal(pointsContainer, points);
        }
        else{
            openPlayerDialogVisitante(pointsContainer, points);
        }
        

        pointsContainer.textContent = parseInt(pointsContainer.textContent) + points;

        pointsLocal = document.querySelector(".points-local .points");
        pointsVisit = document.querySelector(".points-visit .points");

        if(button.parentNode == document.querySelector(".points-local")){
            mostrarlogline("Canasta de locales");
        }
        else{
            mostrarlogline("Canasta de visitantes");
        }
    });
});

function openPlayerDialogLocal(pointsContainer, points) {

    
    // Obtener una lista de jugadores de la base de datos
    sendAjaxRequest('includes/Equipo.php?action=getJugadoresLocales', function(response) {
      let players = JSON.parse(response);
  
      // Crear un cuadro de diálogo modal
      let dialog = document.createElement("div");
      dialog.classList.add("dialog");
  
      // Crear una lista de jugadores
      let playerList = document.createElement("ul");
      players.forEach(player => {
        let listItem = document.createElement("li");
        listItem.textContent = player.name;
        listItem.addEventListener("click", () => {
          // Actualiza la tabla de puntuaciones con los puntos seleccionados
          updateScoreboard(pointsContainer, points, player);
          // Cierra el cuadro de diálogo modal
          dialog.remove();
        });
        playerList.appendChild(listItem);
      });
  
      // Agregar la lista de jugadores al cuadro de diálogo modal
      dialog.appendChild(playerList);
  
      // Agregar el cuadro de diálogo modal a la página
      document.body.appendChild(dialog);
    });
  }

function updateScoreboard(pointsContainer, points, player) {
    // Actualizar el contenedor de puntos con la cantidad de puntos seleccionados
    pointsContainer.textContent = parseInt(pointsContainer.textContent) + points;
  
    // Actualizar la tabla de puntuaciones en la base de datos
    let data = { player: player, points: points };
    sendAjaxRequest("includes/Equipo.php?action=updateScore", function(response) {
      console.log(response);
    });
  }




//

function mostrarVentanaEmergente(accion,equipo) {
    
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();
  
    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        if (this.responseText) {
            // La respuesta ha sido recibida
            // Mostrar la ventana emergente con la lista de jugadores
            console.log("EXITOS AMIGO");
            mostrarListaJugadores(this.responseText, accion,equipo);
          } else {
            console.log("La respuesta está vacía o incompleta.");
          }


      }
    };
  
    // Hacer la solicitud AJAX
    xhttp.open("GET", "obtener_jugadores.php?equipo=" + equipo, true);
    xhttp.send();
}
/*
function mostrarListaJugadores(listaJugadores, accion, equipo) {
    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);
  
    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement("div");
    ventana.classList.add("ventana-emergente");
    document.body.appendChild(ventana);
  
    // Crear una tabla para la lista de jugadores
    var tabla = document.createElement("table");
  
    // Para cada jugador, crear un td con un controlador de eventos click que registre la acción correspondiente

    contador = 0;

    //Parseo el JSON
    let jugadores = JSON.parse(listaJugadores);
   
    var p = document.createElement("p");
    p.textContent = `Equipo: ${equipo}`;
    ventana.appendChild(p);
    for(var j = 0; j < Math.ceil(jugadores.length/3);j++){

        var tr = document.createElement("tr");
    
        contadorFila = 0;
        while(contador < jugadores.length && contadorFila < 4){
            var jugador = jugadores[contador];
            contador++;
            var td = document.createElement("td");
            var boton = document.createElement("button");
            boton.textContent = jugador;
            console.log(jugador);
            boton.addEventListener("click", function() {
                //registrarAccion(jugador, accion, equipo);
                console.log(boton.textContent);
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
            });
            td.appendChild(boton);
            tr.appendChild(td);
            contadorFila++;
        }
        tabla.appendChild(tr);
    }
    ventana.appendChild(tabla);
  
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
  
    // Mostrar la ventana emergente
    ventana.classList.add("mostrar");
}
*/
function mostrarListaJugadores(listaJugadores, accion, equipo) {
    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);
  
    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement("div");
    ventana.classList.add("ventana-emergente");
    document.body.appendChild(ventana);
  
    // Crear una tabla para la lista de jugadores
    var tabla = document.createElement("table");
    contador = 0;
    //Parseo el JSON
    let jugadores = JSON.parse(listaJugadores);
  
    var p = document.createElement("p");
    p.textContent = `Equipo: ${equipo}`;
    ventana.appendChild(p);
  
    for(var j = 0; j < Math.ceil(jugadores.length/3);j++){
      var tr = document.createElement("tr");
  
      contadorFila = 0;
  
      while(contador < jugadores.length && contadorFila < 4){
        var jugador = jugadores[contador];
        contador++;
        var td = document.createElement("td");
        var boton = document.createElement("button");
        boton.textContent = jugador;
        boton.addEventListener("click", crearEventoClick(jugador,accion,equipo));
        td.appendChild(boton);
        tr.appendChild(td);
        contadorFila++;
      }
  
      tabla.appendChild(tr);
    }
  
    ventana.appendChild(tabla);
  
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
  
    // Mostrar la ventana emergente
    ventana.classList.add("mostrar");
  
    // Función para crear el evento click con el valor del jugador como argumento
    function crearEventoClick(jugador) {
      return function() {
        registrarAccion(jugador, accion, equipo);
        ventana.parentNode.removeChild(ventana);
        overlay.parentNode.removeChild(overlay);
      }
    }
}
  
function registrarAccion(jugador, accion, equipo) {
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Exitos");
            //Actualizar la pantalla
            actualizarPantalla(jugador, accion, equipo);
        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "actualizartablaPartido.php?jugador=" + encodeURIComponent(jugador) + "&accion=" + accion + "&equipo=" + equipo, true);
    xhttp.send();
}


function actualizarPantalla(jugador, accion, equipo){

}