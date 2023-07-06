////////////////////////////////////////////////////////////

const idlocal = document.getElementById('accionesLocal').getElementsByTagName('h1')[0].innerText;
const idvisitante = document.getElementById('accionesVisitante').getElementsByTagName('h1')[0].innerText;

const nombreLocal = document.querySelector('.localScore-display h1').textContent;
const nombreVisitante = document.querySelector('.visitScore-display h1').textContent;


//FUNCIONES AUXILIARES:
function isLocal(equipo) {
    if (equipo === idlocal) {
      return true;
    } else{
        return false;
    }
}

function getNombreEquipo(equipo){
    if(isLocal(equipo)){
        return nombreLocal;
    }
    else{
        return nombreVisitante;
    }

}

//////////////////////////////////////////////////////////////////////////
  /*FUNCIONES*/
//////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//APARTADADO DE RELOJ

//VARIABLES
let period = document.getElementById("periodSelect").value;
let duration = document.getElementById("durationSelect").value;


let periodselect = document.getElementById("periodSelect");
let durationselect = document.getElementById("durationSelect");
let starttimer = document.getElementById("start-timer");
let pausetimer = document.getElementById("pause-timer");
let resettimer = document.getElementById("reset-timer");

starttimer.disabled = true;
pausetimer.disabled = true;
resettimer.disabled = false;

//RELOJ CRONOMETRO
let [seconds, minutes] = [0, 10];
let timeRef = document.querySelector(".timer-display");
let int = null;

/*
document.getElementById("durationSelect").addEventListener("change", () => {
    if(gettime){
        // Obtener el valor seleccionado del select
        duration = document.getElementById("durationSelect").value;
        // Actualizar los minutos del cronómetro
        minutes = parseInt(0);
        seconds = 5;
    }
});
*/

//BOTÓN DE START
document.getElementById("start-timer").addEventListener("click", () => {

    periodselect.disabled = true;
    durationselect.disabled = true;
    resettimer.disabled = true;
    
    if(int !== null) {
        clearInterval(int);
    }

    int = setInterval(displayTimer, 1000);
});

//BOTÓN DE PAUSA

// Definir la función de pausa del temporizador
function pausarTemporizador() {
    resettimer.disabled = false;
    periodselect.disabled = false;
    durationselect.disabled = false;
    clearInterval(int);
}

// Asignar la función al evento click del botón
document.getElementById("pause-timer").addEventListener("click", pausarTemporizador);


//BOTÓN DE RESET/PONER TIEMPO
document.getElementById("reset-timer").addEventListener("click", () => {

    period = document.getElementById("periodSelect").value;

    clearInterval(int);

    duration = document.getElementById("durationSelect").value;

    //Iniciar Variable a 0 de Puntos Cuarto.


    // Actualizar los minutos del cronómetro
    minutes = parseInt(duration);
    seconds = 0;

    let m = minutes < 10 ? "0" + minutes : minutes;
    let s = seconds < 10 ? "0" + seconds : seconds;

    timeRef.innerHTML = `${m} : ${s}`;

    starttimer.disabled = false;
    pausetimer.disabled = false;


}); 

//FUNCIONAMIENTO DE MOSTRAR EL RELOJ
function displayTimer() {
    
    if(seconds <= 0) {
        minutes--;
        seconds = 60;
    }

    seconds -= 1;

    //Actualizar Tiempos jugadores
    addsecondplayed();
    getJugadoresPista();

    let m = minutes < 10 ? "0" + minutes : minutes;
    let s = seconds < 10 ? "0" + seconds : seconds;

    timeRef.innerHTML = `${m} : ${s}`;

    if (minutes === 0 && seconds === 0) {
        clearInterval(int);
        timeRef.innerHTML = "Tiempo finalizado";
       
        resettimer.disabled = false;
        periodselect.disabled = false;
        durationselect.disabled = false;

    }
}
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

//BOTÓN DE GRÁFICOS
document.getElementById("graficos-button").addEventListener("click", () => {

    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement("div");
    ventana.classList.add("ventana-graficos");
    document.body.appendChild(ventana);

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

    //Botón 1: Mostrar PDF COMPLETO.

        var mostrarstats = document.createElement('button');
        mostrarstats.classList.add('mostrarstats');
        mostrarstats.innerHTML = 'Estadisticas Completas';
        ventana.appendChild(mostrarstats);
        
        mostrarstats.addEventListener('click', function() {
            generarPDF();
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    //Botón 2: Mostrar PDF Con todo el JUGADA A JUGADA OK

        var playbyplay = document.createElement('button');
        playbyplay.classList.add('playbyplay');
        playbyplay.innerHTML = 'Jugada a Jugada';
        ventana.appendChild(playbyplay);
        
        playbyplay.addEventListener('click', function() {
            generarPDFplaybyplay();
            // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    //Botón 3: Mostrar Box Score (NO PDF) completo de los 12 jugadores OK

        var fullboxscore = document.createElement('button');
        fullboxscore.classList.add('fullboxscore');
        fullboxscore.innerHTML = 'Full Box Score';
        ventana.appendChild(fullboxscore);

        fullboxscore.addEventListener('click', function() {
            // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
            getJugadores(function(jugadores) {
                if (jugadores) {
                  // Acceder a los jugadores aquí
                  console.log(jugadores);
                  
                  // Realizar acciones adicionales con los jugadores
                  // Por ejemplo, guardarlos en una variable global o realizar cálculos basados en los datos de los jugadores
                  mostrarBoxScoreCompleto(jugadores);
                } else {
                  console.log("Error al obtener los jugadores");
                }
              });
            
        });

    //Botón 4: Mostrar PDF Con todos los índices de Estatística Avanzada.

        var estadisticaavanzada = document.createElement('button');
        estadisticaavanzada.classList.add('estadisticaavanzada');
        estadisticaavanzada.innerHTML = 'Estadistica Avanzada';
        ventana.appendChild(estadisticaavanzada);

        estadisticaavanzada.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    //Botón 5: Mostrar PDF con Impacto TimeOuts.

        var impactoTimeOut = document.createElement('button');
        impactoTimeOut.classList.add('impactoTimeOut');
        impactoTimeOut.innerHTML = 'Impacto Time Out';
        ventana.appendChild(impactoTimeOut);

        impactoTimeOut.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    //Botón 6: Mostrar PDF con Impacto Cambios.

        var impactoCambio = document.createElement('button');
        impactoCambio.classList.add('impactoCambio');
        impactoCambio.innerHTML = 'Impacto Cambios';
        ventana.appendChild(impactoCambio);

        impactoCambio.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    //Botón 7: Mostrar PDF con Evaluación X Jugador.

        var evaluacionplayer = document.createElement('button');
        evaluacionplayer.classList.add('evaluacionplayer');
        evaluacionplayer.innerHTML = 'Evaluación Jugador';
        ventana.appendChild(evaluacionplayer);

        evaluacionplayer.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    //Botón 8: Mostrar PDF con Evaluación X Equipo.

        var evaluacionequipo = document.createElement('button');
        evaluacionequipo.classList.add('evaluacionequipo');
        evaluacionequipo.innerHTML = 'Evaluación Equipo';
        ventana.appendChild(evaluacionequipo);

        evaluacionequipo.addEventListener('click', function() {
        // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        });

    // Mostrar la ventana emergente
    ventana.classList.add("mostrar");

});

//Botón 1: Mostrar PDF Completo
function generarPDFcompleto() {


    //Llamar a las funciones que devuelvan el html.

    //1º Llamar a la función de estadisticas.


    // Definir el contenido del documento PDF

    var contenidoPDF = {
        content: [
        { text: 'Estadísitca Completa: ' +  getNombreEquipo(idlocal) + ' vs ' + getNombreEquipo(idvisitante), style: 'header' },
        { text: playbyplay.innerHTML , style: 'body' },
        { text: 'Resultado Final: ' +  getNombreEquipo(idlocal) + ' ' + parseInt(localpointsElement.textContent) + ' vs ' + parseInt(localpointsElement.textContent) + ' ' + getNombreEquipo(idvisitante), style: 'header' },
        ],
        styles: {
        header: { fontSize: 18, bold: true },
        body: { fontSize: 12 }
        }
    };
    
    // Generar el archivo PDF
    var pdfDocGenerator = pdfMake.createPdf(contenidoPDF);
    
    // Descargar el archivo PDF
    pdfDocGenerator.download(idlocal + '.' + idvisitante + '(PlayByPlay).pdf');
}


//1º
function getplantillastats(){

    var jugadores = null;
    jugadores = getJugadores();+
    jugadores.sort((a, b) => b.titular - a.titular); // Ordenar por el campo 'titular' en orden descendente

}

//2º 

function getstatsavanzadas(){


}

//


//Botón 2: Mostrar PDF Con todo el JUGADA A JUGADA
function generarPDFplaybyplay() {
    // Definir el contenido del documento PDF

    let playbyplay = document.querySelector(".info-display");

    var contenidoPDF = {
        content: [
        { text: 'Historial del Partido: ' +  getNombreEquipo(idlocal) + ' vs ' + getNombreEquipo(idvisitante), style: 'header' },
        { text: 'Resultado Final: ' +  getNombreEquipo(idlocal) + ' ' + parseInt(localpointsElement.textContent) + ' vs ' + parseInt(localpointsElement.textContent) + ' ' + getNombreEquipo(idvisitante), style: 'header' },
        { text: playbyplay.innerHTML , style: 'body' }
        ],
        styles: {
        header: { fontSize: 18, bold: true },
        body: { fontSize: 12 }
        }
    };
    
    // Generar el archivo PDF
    var pdfDocGenerator = pdfMake.createPdf(contenidoPDF);
    
    // Descargar el archivo PDF
    pdfDocGenerator.download(idlocal + '.' + idvisitante + '(PlayByPlay).pdf');
}

function getJugadores(callback) {
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();
  
    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
          console.log("La respuesta está completa.");
          // La respuesta ha sido recibida
          var jugadores = JSON.parse(this.responseText);
          callback(jugadores); // Llamar a la devolución de llamada con los jugadores
        } else {
          console.log("La respuesta está vacía o incompleta.");
          callback(null); // Llamar a la devolución de llamada con valor nulo
        }
      }
    };
  
    // Hacer la solicitud AJAX
    xhttp.open("GET", "getJugadores.php", true);
    xhttp.send();
  }
  
  function guardarvariable() {
    
  }
  

function mostrarBoxScoreCompleto(jugadores) {

    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement('div');
    ventana.classList.add("ventana-graficos");
    document.body.appendChild(ventana);

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

    var localfullTable = document.createElement('table');
    var visitfullTable = document.createElement('table');

    // Crear la primera fila para el nombre del equipo
    var localfullTeamRow = localfullTable.insertRow();
    var visitfullTeamRow = visitfullTable.insertRow();

    var localfullTeamCell = localfullTeamRow.insertCell();
    localfullTeamCell.colSpan = 12;
    localfullTeamCell.innerHTML = 'Equipo Local';

    var visitfullTeamCell = visitfullTeamRow.insertCell();
    visitfullTeamCell.colSpan =12;
    visitfullTeamCell.innerHTML = 'Equipo Visitante';

    // Crear la segunda fila para las cabeceras
    var localfullHeaderRow = localfullTable.insertRow();
    var visitfullHeaderRow = visitfullTable.insertRow();

    var headers = ['Nº', 'Nombre', 'Ptos.', 'Faltas', 'Time'];

    for (var i = 0; i < headers.length; i++) {
        var localfullHeaderCell = localfullHeaderRow.insertCell();
        localfullHeaderCell.innerHTML = headers[i];

        var visitfullHeaderCell = visitfullHeaderRow.insertCell();
        visitfullHeaderCell.innerHTML = headers[i];
    }

    //Ordeno para obtener primero a los titulares.
    jugadores.sort((a, b) => b.titular - a.titular); // Ordenar por el campo 'titular' en orden descendente


    // Recorrer los jugadores y agregarlos a las tablas
    for (var i = 0; i < jugadores.length; i++) {
        var jugador = jugadores[i];

        // Cálculo de puntos, faltas y tiempo
        var puntosPlayer = (jugador.T2A * 2) + (jugador.T3A * 3) + (jugador.TLA * 1);
        var faltasPlayer = jugador.FLH;
        var minutosjugador = Math.floor(jugador.segundosjugados / 60);
        var segundosjugador = jugador.segundosjugados % 60;
        var minutosPlayer = `${minutosjugador.toString().padStart(2, '0')}:${segundosjugador.toString().padStart(2, '0')}`;

        var playerfullRow = document.createElement('tr');

        // Crear las celdas para los datos del jugador
        var numberfullCell = playerfullRow.insertCell();
        numberfullCell.innerHTML = jugador.numero;

        var namefullCell = playerfullRow.insertCell();
        namefullCell.innerHTML = jugador.nombrejugador;

        var pointsfullCell = playerfullRow.insertCell();
        pointsfullCell.innerHTML = puntosPlayer;

        var foulsfullCell = playerfullRow.insertCell();
        foulsfullCell.innerHTML = faltasPlayer;

        var timefullCell = playerfullRow.insertCell();
        timefullCell.innerHTML = minutosPlayer;

        if (isLocal(jugador.equipo)) {
            localfullTable.appendChild(playerfullRow);
        } else {
            visitfullTable.appendChild(playerfullRow);
        }
    }

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var displaytablas = document.createElement("div");
    displaytablas.classList.add("displaytablas");
    ventana.appendChild(displaytablas);

    // Obtener los elementos de anclaje para las tablas
    var localfullPlayersDisplay = document.createElement('div');
    var visitfullPlayersDisplay = document.createElement('div');

    // Agregar las tablas al contenedor correspondiente
    localfullPlayersDisplay.innerHTML = '';
    localfullPlayersDisplay.appendChild(localfullTable);

    visitfullPlayersDisplay.innerHTML = '';
    visitfullPlayersDisplay.appendChild(visitfullTable);

    displaytablas.appendChild(localfullPlayersDisplay);
    displaytablas.appendChild(visitfullPlayersDisplay);

    generarPDFStats(displaytablas);
}

function generarPDFStats(displaytablas) {
    // Crear un nuevo documento jsPDF
    var doc = new jsPDF();
  
    // Obtener el contenido HTML del elemento displaytablas
    var htmlContent = displaytablas.innerHTML;
  
    // Definir las opciones de formato para el contenido HTML
    var options = {
      html2canvas: { scale: 2 },
      margin: { top: 20, bottom: 20, left: 20, right: 20 },
    };
  
    // Generar el PDF a partir del contenido HTML
    doc.html(htmlContent, options).then(function () {
      // Descargar el archivo PDF
      doc.save(idlocal + '.' + idvisitante + '(Stats).pdf');
    });
  }
  
/*
function htmlToPlainText(html) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(html, 'text/html');
    return doc.body.textContent || '';
  }
  

function generarPDFStats(displaytablas) {
    // Convertir el contenido HTML a texto plano
    var plainTextContent = htmlToPlainText(displaytablas.innerHTML);
    
    // Mostrar en la consola
    console.log(displaytablas.innerHTML);
    console.log(plainTextContent);
    
    // Definir el contenido del documento PDF
    var contenido = {
      content: [
        plainTextContent
      ]
    };
    
    // Generar el archivo PDF
    var pdfDocGenerator = pdfMake.createPdf(contenido);
    
    // Descargar el archivo PDF
    pdfDocGenerator.download(idlocal + '.' + idvisitante + '(Stats).pdf');
  }*/
  
  


/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//MARCADOR DE PUNTOS

// Obtener el elemento con la clase "localScore-display"
let localScoreDisplay = document.querySelector('.localScore-display');
// Obtener el elemento con la clase "points" dentro del elemento "localScoreDisplay"
let localpointsElement = localScoreDisplay.querySelector('.points');
// Obtener el elemento con la clase "visitScore-display"
let visitScoreDisplay = document.querySelector('.visitScore-display');
// Obtener el elemento con la clase "points" dentro del elemento "visitScoreDisplay"
let visitpointsElement = visitScoreDisplay.querySelector('.points');

function addPoints(equipo,jugador,puntos){
    if(isLocal(equipo)){
        // Actualizar el valor del marcador
        localpointsElement.textContent = parseInt(localpointsElement.textContent) + puntos;
        actualizarDatosPuntos(puntos,equipo);
        
    }
    else{
        // Actualizar el valor del marcador
        visitpointsElement.textContent = parseInt(visitpointsElement.textContent) + puntos;
        actualizarDatosPuntos(puntos,equipo);
    }

    mostrarMensajeLogLine("Canasta de " + puntos + " del Nº " + jugador + " de " + getNombreEquipo(equipo));
}

function actualizarpuntoscuarto(){

    //Guardar la variable de Puntos Cuarto

    period = document.getElementById("periodSelect").value;

    switch(period){
        case 'Periodo 1':
            cuarto = 1;
            break;

        case 'Periodo 2':
            cuarto = 2;
            break;

        case 'Periodo 3':
            cuarto = 3;
            break;

        case 'Periodo 4':
            cuarto = 4;
            break;
        default:
            cuarto = 5;
        break;
    }

    //LLamar a función de recopilar datos de ese cuarto.
    guardarpuntoscuarto(idlocal,idvisitante,parseInt(localpointsElement.textContent),parseInt(visitpointsElement.textContent),cuarto);
}

function actualizarDatosPuntos(puntos,equipo){
    //1º Actualizar más menos de los jugadores
    actualizarmasmenos(puntos,equipo);
    // 2º Guardar los puntos en total y 3º Añadir puntos al cuarto
    actualizarpuntoscuarto();
    //4º Checkear si hay empate y 5º Checkear alternancia en marcador
    checkmarcador();
    // 6º Parciales??
}

//ACTUALIZAR MAS/MENOS
function actualizarmasmenos(puntos,equipo){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa en mas menos.");
        }
        else{
            console.log("La respuesta está  NO completa en mas menos.");

        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "actualizarmasmenos.php?puntos=" + puntos + "&equipo=" + equipo, true);
    xhttp.send();
}

//ACTUALIZAR PUNTOSCUARTO
function guardarpuntoscuarto(equipolocal,equipovisitante,puntoslocal,puntosvisitante,cuarto){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa en guardarpuntoscuarto.");
        }
        else{
            console.log("La respuesta está  NO completa en guardarpuntoscuarto.");

        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "guardarpuntoscuarto.php?equipolocal=" + equipolocal + "&equipovisitante=" + equipovisitante + "&puntoslocal=" + puntoslocal + "&puntosvisitante=" + puntosvisitante + "&cuarto=" + cuarto, true);
    xhttp.send();
}

//CHECK MARCADOR
function checkmarcador(){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa en checkmarcador.");
        }
        else{
            console.log("La respuesta está  NO completa en checkmarcador.");

        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "checkmarcador.php", true);
    xhttp.send();
}


/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//TIEMPOS MUERTOS y FALTAS BANQUILLO

let timeoutLocal = document.querySelector(".timeout-local .timeout");
let timeoutVisit = document.querySelector(".timeout-visit .timeout");
let addTimeoutButtons = document.querySelectorAll(".add-timeout");

// Obtener el elemento con la clase "buttons-coach-local"
let localbuttonscoach = document.querySelector('.buttons-coach-local');
// Obtener el elemento con la clase "timeout" dentro del elemento "buttonscoachlocal"
let localtimeout = localbuttonscoach.querySelector('.timeout');
// Obtener el elemento con la clase "faltabanquillo" dentro del elemento "buttonscoachlocal"
let localfaltabanquillo = localbuttonscoach.querySelector('.faltabanquillo');

// Obtener el elemento con la clase "buttons-coach-visit"
let visitbuttonscoach = document.querySelector('.buttons-coach-visit');
// Obtener el elemento con la clase "timeout" dentro del elemento "buttonscoachlocal"
let visittimeout = visitbuttonscoach.querySelector('.timeout');
// Obtener el elemento con la clase "faltabanquillo" dentro del elemento "buttonscoachlocal"
let visitfaltabanquillo = visitbuttonscoach.querySelector('.faltabanquillo');

function addTimeOut(equipo){
    if(isLocal(equipo)){
        // Actualizar el valor del marcador
        localtimeout.textContent = parseInt(localtimeout.textContent) + 1;
        pausarTemporizador();
        timeout(equipo);
        
    }
    else{
        // Actualizar el valor del marcador
        visittimeout.textContent = parseInt(visittimeout.textContent) + 1;
        pausarTemporizador();
        timeout(equipo);
    }

    mostrarMensajeLogLine("Tiempo Muerto de " + getNombreEquipo(equipo));
}


function addFaltaBanquillo(equipo){
    if(isLocal(equipo)){
        // Actualizar el valor del marcador
        localfaltabanquillo.textContent = parseInt(localfaltabanquillo.textContent) + 1;
        pausarTemporizador();
        faltabanquillo(equipo);
        
    }
    else{
        // Actualizar el valor del marcador
        visitfaltabanquillo.textContent = parseInt(visitfaltabanquillo.textContent) + 1;
        pausarTemporizador();
        faltabanquillo(equipo);
    }

    mostrarMensajeLogLine("Falta de Banquillo de " + getNombreEquipo(equipo));
}

function timeout(equipo){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa.");
        }
    };
  
    // Hacer la solicitud AJAX
    xhttp.open("GET", "timeout.php?equipo=" + equipo, true);
    xhttp.send();

}

function faltabanquillo(equipo){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa.");
        }
    };
  
    // Hacer la solicitud AJAX
    xhttp.open("GET", "faltabanquillo.php?equipo=" + equipo, true);
    xhttp.send();

}

/*
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
*/

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//MINUTAJE JUGADORES

function addsecondplayed(){
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa.");
        }
    };

    // Hacer la solicitud AJAX POST
    xhttp.open("GET", "addsecondplayed.php", true);
    xhttp.send();
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//JUGADORES EN PISTA

// Obtener el elemento con la clase "localScore-display"
let localPlayersDisplay = document.querySelector('.localPlayers-display');
// Obtener el elemento con la clase "visitScore-display"
let visitPlayersDisplay = document.querySelector('.visitPlayers-display');

/*function mostrarJugadoresPista(jugadores){

    var playersLocalHTML = '';

    var playersVisitHTML = '';

    var puntosPlayer = '';

    var faltasPlayer = '';

    var minutosPlayer = '';

        for (var i = 0; i < jugadores.length; i++) {
            var jugador = jugadores[i];
        
            //Calculo sus puntos faltas y minutos

            puntosPlayer = (jugador.T2A * 2) + (jugador.T3A * 3) + (jugador.TLA * 1);

            faltasPlayer = jugador.FLH;

            var minutosjugador = Math.floor(jugador.segundosjugados / 60); // Calcula los minutos (parte entera)
            var segundosjugador = jugador.segundosjugados % 60; // Calcula los segundos restantes

           // Formatea la cadena en el formato mm:ss sin utilizar sprintf()
            minutosPlayer = `${minutosjugador.toString().padStart(2, '0')}:${segundosjugador.toString().padStart(2, '0')}`;

            if(isLocal(jugador.equipo)){

                playersLocalHTML += '<div>#' + jugador.numero + ' Nombre: ' + jugador.nombrejugador + ' Puntos: ' + puntosPlayer + ' Faltas: ' + faltasPlayer + ' Minutos: ' + minutosPlayer + '</div>';



            }
            else{
                playersVisitHTML += '<div>Número: ' + jugador.numero + ', Nombre: ' + jugador.nombrejugador + '</div>';
            }
        
        }

        localPlayersDisplay.innerHTML = playersLocalHTML;
        visitPlayersDisplay.innerHTML = playersVisitHTML;
}*/

function mostrarJugadoresPista(jugadores) {
    var playersLocalHTML = '';
    var playersVisitHTML = '';

    var localTable = document.createElement('table');
    var visitTable = document.createElement('table');

    // Crear la primera fila para el nombre del equipo
    var localTeamRow = localTable.insertRow();
    var visitTeamRow = visitTable.insertRow();

    var localTeamCell = localTeamRow.insertCell();
    localTeamCell.colSpan = 5;
    localTeamCell.innerHTML = 'Equipo Local';

    var visitTeamCell = visitTeamRow.insertCell();
    visitTeamCell.colSpan = 5;
    visitTeamCell.innerHTML = 'Equipo Visitante';

    // Crear la segunda fila para las cabeceras
    var localHeaderRow = localTable.insertRow();
    var visitHeaderRow = visitTable.insertRow();

    var headers = ['Nº', 'Nombre', 'Ptos.', 'Faltas', 'Time'];

    for (var i = 0; i < headers.length; i++) {
        var localHeaderCell = localHeaderRow.insertCell();
        localHeaderCell.innerHTML = headers[i];

        var visitHeaderCell = visitHeaderRow.insertCell();
        visitHeaderCell.innerHTML = headers[i];
    }

    // Recorrer los jugadores y agregarlos a las tablas
    for (var i = 0; i < jugadores.length; i++) {
        var jugador = jugadores[i];

        // Cálculo de puntos, faltas y tiempo
        var puntosPlayer = (jugador.T2A * 2) + (jugador.T3A * 3) + (jugador.TLA * 1);
        var faltasPlayer = jugador.FLH;
        var minutosjugador = Math.floor(jugador.segundosjugados / 60);
        var segundosjugador = jugador.segundosjugados % 60;
        var minutosPlayer = `${minutosjugador.toString().padStart(2, '0')}:${segundosjugador.toString().padStart(2, '0')}`;

        var playerRow = document.createElement('tr');

        // Crear las celdas para los datos del jugador
        var numberCell = playerRow.insertCell();
        numberCell.innerHTML = jugador.numero;

        var nameCell = playerRow.insertCell();
        nameCell.innerHTML = jugador.nombrejugador;

        var pointsCell = playerRow.insertCell();
        pointsCell.innerHTML = puntosPlayer;

        var foulsCell = playerRow.insertCell();
        foulsCell.innerHTML = faltasPlayer;

        var timeCell = playerRow.insertCell();
        timeCell.innerHTML = minutosPlayer;

        if (isLocal(jugador.equipo)) {
            localTable.appendChild(playerRow);
        } else {
            visitTable.appendChild(playerRow);
        }
    }

    // Agregar las tablas al contenedor correspondiente
    localPlayersDisplay.innerHTML = '';
    localPlayersDisplay.appendChild(localTable);

    visitPlayersDisplay.innerHTML = '';
    visitPlayersDisplay.appendChild(visitTable);
}


//Función para obtener el string de los jugadores con en_juego activo.
function getJugadoresPista() {
    
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            if (this.responseText) {
                console.log("La respuesta está completa.");                
                // La respuesta ha sido recibida
                mostrarJugadoresPista(JSON.parse(this.responseText));
            } else {
                console.log("La respuesta está vacía o incompleta.");
              }
          }
        };
      
        // Hacer la solicitud AJAX
        xhttp.open("GET", "getJugadoresPista.php", true);
        xhttp.send();
}

////////////////////////////////////////////////////////////////////////////////////////////

//SUSTITUCIONES

function mostrarVentanaSub(equipo){

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();
    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        if (this.responseText) {
            // La respuesta ha sido recibida
            // Mostrar la ventana emergente con la lista de jugadores
            mostrarListaJugadoresSub(JSON.parse(this.responseText), equipo);
          } else {
            console.log("La respuesta está vacía o incompleta.");
        }
      }
    };
  
    // Hacer la solicitud AJAX
    xhttp.open("GET", "obtener_jugadoresSub.php?equipo=" + equipo, true);
    xhttp.send();

}

function makecambio(listajugadores){

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
    xhttp.open("POST", "makecambio.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(listaJugadoresJSON);
}


function mostrarListaJugadoresSub(jugadores,equipo){
    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement("div");
    ventana.classList.add("ventana-sustitucion");
    document.body.appendChild(ventana);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var sustitucion = document.createElement("h1");
    sustitucion.textContent = `Selecciona la sustitucion del equipo`;
    ventana.appendChild(sustitucion);

    // Crear los contenedores de lista para los jugadores 
    var contenedorListas = document.createElement('div');
    contenedorListas.classList.add('contenedor-listas');
    ventana.appendChild(contenedorListas);

    // Crear los contenedores de lista para los jugadores locales y visitantes
    var contenedorJugadoresEnPista = document.createElement('div');
    contenedorJugadoresEnPista.classList.add('contenedor-jugadoresEnPista');
    contenedorListas.appendChild(contenedorJugadoresEnPista);

    var contenedorJugadoresEnBanquillo = document.createElement('div');
    contenedorJugadoresEnBanquillo.classList.add('contenedor-jugadoresEnBanquillo');
    contenedorListas.appendChild(contenedorJugadoresEnBanquillo);

    var p = document.createElement("p");
    p.textContent = `Jugando en ${equipo}`;
    contenedorJugadoresEnPista.appendChild(p);

    var p = document.createElement("p");
    p.textContent = `Banquillo en ${equipo}`;
    contenedorJugadoresEnBanquillo.appendChild(p);

    // Crear las listas de jugadores y agregarlos a los contenedores
    var listaJugadoresEnPista = document.createElement('ul');
    listaJugadoresEnPista.classList.add('lista-jugadores');
    contenedorJugadoresEnPista.appendChild(listaJugadoresEnPista);

    var listaJugadoresEnBanquillo = document.createElement('ul');
    listaJugadoresEnBanquillo.classList.add('lista-jugadores');
    contenedorJugadoresEnBanquillo.appendChild(listaJugadoresEnBanquillo);

    // Agregar los jugadores a cada lista

    console.log(jugadores);

    var jugadoresEnPista = [];
    var jugadoresEnBanquillo = [];
    
    jugadores.forEach(function(jugador){
        if (jugador.en_juego === '1') {
        jugadoresEnPista.push(jugador);
        } else {
        jugadoresEnBanquillo.push(jugador);
        }
    });    
    
    jugadoresEnPista.forEach(function(jugador) {
        var li = document.createElement('li');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        li.appendChild(checkbox);
        li.appendChild(document.createTextNode(jugador.numero + '-' + jugador.jugador + '-' + jugador.nombrejugador));
        listaJugadoresEnPista.appendChild(li);
    });

    jugadoresEnBanquillo.forEach(function(jugador) {
        var li = document.createElement('li');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        li.appendChild(checkbox);
        li.appendChild(document.createTextNode(jugador.numero + '-' + jugador.jugador + '-' + jugador.nombrejugador));
        listaJugadoresEnBanquillo.appendChild(li);
    });

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

    // Crear el botón de confirmar y agregar el controlador de eventos
    var confirmar = document.createElement('button');
    confirmar.classList.add('confirmar');
    confirmar.innerHTML = 'Confirmar Cambio';
    ventana.appendChild(confirmar);
    
    confirmar.addEventListener('click', function() {
        // Obtener los jugadores seleccionados
        var jugadoresSeleccionados = [];
        var checkboxesSeleccionados = document.querySelectorAll('input[type="checkbox"]:checked');
        checkboxesSeleccionados.forEach(function(checkbox) {
            var jugador = checkbox.parentNode.textContent.split('-');
            jugadoresSeleccionados.push({numero: jugador[0], jugador: jugador[1]});
        });
        // Validar que se hayan seleccionado 5 jugadores locales y 5 visitantes
        var cantidadEnJuego = document.querySelectorAll('.contenedor-jugadoresEnPista:nth-child(1) input[type="checkbox"]:checked').length;
        var cantidadEnBanquillo = document.querySelectorAll('.contenedor-jugadoresEnBanquillo:nth-child(2) input[type="checkbox"]:checked').length;
        if (cantidadEnJuego === 1 && cantidadEnBanquillo === 1) {
            console.log(jugadoresSeleccionados);
            // Llamar a una función con los jugadores seleccionados
            makecambio(jugadoresSeleccionados);
            getJugadoresPista();
            
            // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
        } else {
            alert('Por favor, seleccione 1 jugador de pista y otro de banquillo para continuar');
        }
    });

    // Mostrar la ventana emergente
    ventana.classList.add("mostrar");

}

////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////



function missedShot(equipo,jugador,puntos){
    mostrarMensajeLogLine("Tiro de " + puntos + " fallado del Nº " + jugador + " de " + getNombreEquipo(equipo));
}


//////////////////////////////////////////////////////////////////////////////////

//Ventana Emergente que muestra los jugadores en juego, para X equipo, para asignarles X accion

function mostrarVentanaEmergente(accion,equipo) {
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();
    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        if (this.responseText) {
            // La respuesta ha sido recibida
            // Mostrar la ventana emergente con la lista de jugadores
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
        boton.textContent = jugador.numero + '-' + jugador.nombrejugador;
        boton.addEventListener("click", crearEventoClick(jugador.numero,accion,equipo));
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
            //Actualizar la pantalla
            actualizarPantalla(jugador, accion, equipo);
        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "actualizartablaPartido.php?jugador=" + encodeURIComponent(jugador) + "&accion=" + accion + "&equipo=" + equipo, true);
    xhttp.send();
}

function mostrarMensajeLogLine(mensaje){

    let infoRef = document.querySelector(".info-display");
    let logline = '';
    period = document.getElementById("periodSelect").value;
    logline = `¡${mensaje}! [${period}-Time: ${minutes}:${seconds}-(H:${localpointsElement.textContent} - V:${visitpointsElement.textContent})]\n`;
    infoRef.innerHTML += logline ;
}

function actualizarComparativa(campo,equipo){
    if(isLocal(equipo)){
        var parametro = '.' + campo + '-Local';

        let  elemento = document.querySelector(parametro);
        elemento.textContent = parseInt(elemento.textContent) + 1;
    }
    else{
        var parametro = '.' + campo + '-Visitante';


        let  elemento = document.querySelector(parametro);
        elemento.textContent = parseInt(elemento.textContent) + 1;
    }
    getJugadoresPista();
}

function actualizarTotalTiros(campo,equipo){
    if(isLocal(equipo)){
        let nuevoString = campo.slice(0, campo.length - 1);
        var parametro = '.' + nuevoString + 'T-Local';

        let  elemento = document.querySelector(parametro);
        elemento.textContent = parseInt(elemento.textContent) + 1;
    }
    else{
        let nuevoString = campo.slice(0, campo.length - 1);
        var parametro = '.' + nuevoString + 'T-Visitante';


        let  elemento = document.querySelector(parametro);
        elemento.textContent = parseInt(elemento.textContent) + 1;
    }
}
function actualizarPorcentaje(campo,equipo){
    if(isLocal(equipo)){

        let nuevoString = campo.slice(0, campo.length - 1);

        var parametro = '.' + nuevoString + 'P-Local';
        let  elemento = document.querySelector(parametro);

        var anot = '.' + nuevoString + 'A-Local';
        let  anotados = document.querySelector(anot);

        var fall = '.' + nuevoString + 'F-Local';
        let  fallados = document.querySelector(fall);

        elemento.textContent = ( (parseInt(anotados.textContent) / (parseInt(anotados.textContent) + parseInt(fallados.textContent))).toFixed(2) ) * 100;

    }
    else{

        let nuevoString = campo.slice(0, campo.length - 1);

        var parametro = '.' + nuevoString + 'P-Visitante';
        let  elemento = document.querySelector(parametro);

        var anot = '.' + nuevoString + 'A-Visitante';
        let  anotados = document.querySelector(anot);

        var fall = '.' + nuevoString + 'F-Visitante';
        let  fallados = document.querySelector(fall);


        elemento.textContent = ( (parseInt(anotados.textContent) / (parseInt(anotados.textContent) + parseInt(fallados.textContent))).toFixed(2) ) * 100;

    }
}

function actualizarTotalRebotes(equipo){

    if(isLocal(equipo)){
        var parametro = '.RB-Local';

        let  elemento = document.querySelector(parametro);
        elemento.textContent = parseInt(elemento.textContent) + 1;
    }
    else{
        var parametro = ".RB-Visitante";


        let  elemento = document.querySelector(parametro);
        elemento.textContent = parseInt(elemento.textContent) + 1;
    }

}

function actualizarPantalla(jugador, accion, equipo){

    //1º Mostrar el Mensaje del LogLine
    // 2º Actualizar Comparativa o Marcador
    switch (accion) {
        case 'T2A':
        // Lógica para actualizar la pantalla cuando se registra un T2A
        addPoints(equipo,jugador,2);
        actualizarComparativa(accion,equipo);
        actualizarTotalTiros(accion,equipo)
        actualizarPorcentaje(accion,equipo);
        break;
        case 'T2F':
        // Lógica para actualizar la pantalla cuando se registra un T2F
        missedShot(equipo,jugador,2);
        actualizarComparativa(accion,equipo);
        actualizarTotalTiros(accion,equipo)
        actualizarPorcentaje(accion,equipo);
        break;
        case 'T3A':
        // Lógica para actualizar la pantalla cuando se registra un T3A
        addPoints(equipo,jugador,3);
        actualizarComparativa(accion,equipo);
        actualizarTotalTiros(accion,equipo)
        actualizarPorcentaje(accion,equipo);
        break;
        case 'T3F':
        // Lógica para actualizar la pantalla cuando se registra un T3F
        missedShot(equipo,jugador,3);
        actualizarComparativa(accion,equipo);
        actualizarTotalTiros(accion,equipo)
        actualizarPorcentaje(accion,equipo);
        break;
        case 'TLA':
        // Lógica para actualizar la pantalla cuando se registra un TLA
        addPoints(equipo,jugador,1);
        actualizarComparativa(accion,equipo);
        actualizarTotalTiros(accion,equipo)
        actualizarPorcentaje(accion,equipo);
        break;
        case 'TLF':
        // Lógica para actualizar la pantalla cuando se registra un TLF
        missedShot(equipo,jugador,1);
        actualizarComparativa(accion,equipo);
        actualizarTotalTiros(accion,equipo)
        actualizarPorcentaje(accion,equipo);
        break;
        case 'FLH':
        // Lógica para actualizar la pantalla cuando se registra una FAL
        mostrarMensajeLogLine("Falta hecha por el Nº " + jugador + " de " + getNombreEquipo(equipo));
        pausarTemporizador();
        actualizarComparativa(accion,equipo);
        break;
        case 'FLR':
        // Lógica para actualizar la pantalla cuando se registra una FAL
        mostrarMensajeLogLine("Falta recibida por Nº " + jugador + " de " + getNombreEquipo(equipo));
        break;
        case 'TEC':
        // Lógica para actualizar la pantalla cuando se registra un TEC
        mostrarMensajeLogLine("Falta Técnica del Nº " + jugador + " de " + getNombreEquipo(equipo));
        pausarTemporizador();
        actualizarComparativa('FLH',equipo);
        break;
        case 'RBO':
        // Lógica para actualizar la pantalla cuando se registra un RBO
        mostrarMensajeLogLine("Rebote Ofensivo del Nº " + jugador + " de " + getNombreEquipo(equipo));
        actualizarComparativa(accion,equipo);
        actualizarTotalRebotes(equipo);
        break;
        case 'RBD':
        // Lógica para actualizar la pantalla cuando se registra un RBD
        mostrarMensajeLogLine("Rebote Defensivo del Nº " + jugador + " de " + getNombreEquipo(equipo));
        actualizarComparativa(accion,equipo);
        actualizarTotalRebotes(equipo);
        break;
        case 'ROB':
        // Lógica para actualizar la pantalla cuando se registra un ROB
        mostrarMensajeLogLine("Robo del Nº " + jugador + " de " + getNombreEquipo(equipo));
        actualizarComparativa(accion,equipo);
        break;
        case 'TAP':
        // Lógica para actualizar la pantalla cuando se registra un TAP
        mostrarMensajeLogLine("Tapón del Nº " + jugador + " de " + getNombreEquipo(equipo));
        actualizarComparativa(accion,equipo);
        break;
        case 'PRD':
        // Lógica para actualizar la pantalla cuando se registra un PRD
        mostrarMensajeLogLine("Pérdida del Nº " + jugador + " de " + getNombreEquipo(equipo));
        actualizarComparativa(accion,equipo);
        break;
        case 'AST':
        // Lógica para actualizar la pantalla cuando se registra un AST
        mostrarMensajeLogLine("Asistencia del Nº " + jugador + " de " + getNombreEquipo(equipo));
        actualizarComparativa(accion,equipo);
        break;
        default:
        // Lógica para manejar casos en los que la acción no esté definida
        break;
    }
}




///////////////////
window.addEventListener('beforeunload', function (e) {
    // Cancela el evento de cierre para mostrar el cuadro de diálogo
    e.preventDefault();
    // La mayoría de los navegadores modernos requieren que se le asigne un valor a la propiedad returnValue del evento
    e.returnValue = '';
  
    // Muestra el mensaje de confirmación personalizado
    var confirmationMessage = '¿Estás seguro de que deseas abandonar esta página?';
  
    // Retorna el mensaje de confirmación
    return confirmationMessage;
  });
  