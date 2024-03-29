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
        let ganador = saberganador();

        addsecondplayed();
        getJugadoresPista();
        addtiempoLider(ganador);

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
/*APARTADO MARCADORES DE LOS EQUIPOS*/
/////////////////////////////////////////////////////////////

    let idpartidoDisplay = document.querySelector('.idpartido-display');
    let idpartidoElement = idpartidoDisplay.querySelector('.id');

    function saberganador(){

        if((parseInt(localpointsElement.textContent)) > (parseInt(visitpointsElement.textContent))){

            return 1;

        }
        else{
            if((parseInt(localpointsElement.textContent)) < (parseInt(visitpointsElement.textContent))){
                return 0;
            }
            else{
                return 2;
            }
        }
    }

    document.getElementById("endgame-button").addEventListener("click", () => {
        // Mostrar ventana de confirmación
        var confirmacion = confirm("¿Estás seguro de que deseas finalizar el partido?");

        // Si se hace clic en "Aceptar", realizar las acciones
        if (confirmacion) {
            // Guardar los datos para cada jugador
            ganador = saberganador();
            var idMatch = idpartidoElement.textContent;
            saveplayers(ganador,idMatch);
        }
    });

    function saveplayers($ganador,$id){

        //Guardar las tablas, renombrandolas
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();

        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("La respuesta está completa en save players.");
            
            // Guardar la información de las tablas para futuras consultas y redirigir al index
            renametables();
            window.location.href = "index.php"; 
        }
        else{
            console.log("La respuesta está  NO completa en save players.");

        }
        };

        xhttp.open("GET", "saveplayers.php?equipo=" + idlocal + "&ganador=" + $ganador + "&idPartido=" + $id, true);
        xhttp.send();
        
    }

    function renametables(){

            //Guardar las tablas, renombrandolas
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
        xhttp.open("GET", "renombrartablas.php?id=" + parseInt(idpartidoElement.textContent), true);
        xhttp.send();
    }


    
/////////////////////////////////////////////////////////////
/*BOTÓN DE GRÁFICOS Y TODA LA FUNCIONALIDAD*/
/////////////////////////////////////////////////////////////

    document.getElementById("eliminaraccion-button").addEventListener("click",() =>{
        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement("div");
        ventana.classList.add("ventana-graficos");
        document.body.appendChild(ventana);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var titulo = document.createElement("h1");
        titulo.textContent = `¿De que equipo quieres eliminar una accion?`;
        ventana.appendChild(titulo);

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

        var equipolocal = document.createElement('button');
        equipolocal.classList.add('equipolocal');
        equipolocal.innerHTML = 'Local';
        ventana.appendChild(equipolocal);

        equipolocal.addEventListener('click', function() {
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
            getJugadoresEquipo(function(jugadores) {
                if (jugadores) {
                    mostrarVentanaEliminarAccionJugador(jugadores);
                } else {
                    console.log("Error al obtener los jugadores");
                }
            }, idlocal);  
        });

        var equipovisitante = document.createElement('button');
        equipovisitante.classList.add('equipovisitante');
        equipovisitante.innerHTML = 'Visitante';
        ventana.appendChild(equipovisitante);

        equipovisitante.addEventListener('click', function() {
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
            getJugadoresEquipo(function(jugadores) {
                if (jugadores) {
                    mostrarVentanaEliminarAccionJugador(jugadores);
                } else {
                    console.log("Error al obtener los jugadores");
                }
            }, idvisitante);   
        });
    });

    document.getElementById("graficos-button").addEventListener("click", () => {

        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement("div");
        ventana.classList.add("ventana-graficos");
        document.body.appendChild(ventana);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var titulo = document.createElement("h1");
        titulo.textContent = `¿Qué quieres consultar?`;
        ventana.appendChild(titulo);

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

        //Botón 0: Guardar PDF con todo.

            var pdfcompleto = document.createElement('button');
            pdfcompleto.classList.add('pdfcompleto');
            pdfcompleto.innerHTML = 'GENERAR PDFS';
            ventana.appendChild(pdfcompleto);

            pdfcompleto.addEventListener('click', function() {
                generarPDFS();
            });

        //Botón 1: Mostrar Estadistica Completa (CORRECTO)

            var mostrarstats = document.createElement('button');
            mostrarstats.classList.add('mostrarstats');
            mostrarstats.innerHTML = 'Estadisticas Completas';
            ventana.appendChild(mostrarstats);
            
            mostrarstats.addEventListener('click', function() {
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
                getJugadoresEstadisticas(function(jugadores) {
                    if (jugadores) {
                        getEquiposEstadisticas(function(equipos) {
                            if (equipos) {
                            mostrarEstadisticaCompleta(jugadores,equipos);
                            } else {
                            console.log("Error al obtener los jugadores");
                            }
                        });
                    } else {
                    console.log("Error al obtener los jugadores");
                    }
                });
            });


            //Botón 2: Mostrar Estadistica Completa PDF(CORRECTO)

            var mostrarstatsPDF = document.createElement('button');
            mostrarstatsPDF.classList.add('mostrarstatsPDF');
            mostrarstatsPDF.innerHTML = 'Estadisticas Completas PDF';
            ventana.appendChild(mostrarstatsPDF);
            
            mostrarstatsPDF.addEventListener('click', function() {
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
                getJugadoresEstadisticas(function(jugadores) {
                    if (jugadores) {
                        getEquiposEstadisticas(function(equipos) {
                            if (equipos) {
                                getFecha(function (fecha) {
                                    if (fecha) {
                                        const doc1 = generarPDFestadisticaCompleta(jugadores,equipos);
                                        doc1.save(idlocal + 'vs' + idvisitante +'(' + fecha + ')-(Stats).pdf');
                                    } else {
                                        console.log("Error al obtener la fecha");
                                    }
                                });
                            } else {
                            console.log("Error al obtener los jugadores");
                            }
                        });
                    } else {
                    console.log("Error al obtener los jugadores");
                    }
                });
            });
        //Botón 2: Mostrar Box Score  completo de los 12 jugadores (CORRECTO)

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
                    // Por ejemplo, guardarlos en una variable global o realizar cálculos basados en los datos de los jugadores
                    mostrarBoxScoreCompleto(jugadores);
                    } else {
                    console.log("Error al obtener los jugadores");
                    }
                });
            });

        //Botón 2: Mostrar Box Score PDF completo de los 12 jugadores (CORRECTO)

            var fullboxscorePDF = document.createElement('button');
            fullboxscorePDF.classList.add('fullboxscorePDF');
            fullboxscorePDF.innerHTML = 'Full Box Score PDF';
            ventana.appendChild(fullboxscorePDF);

            fullboxscorePDF.addEventListener('click', function() {
                // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
                getJugadores(function(jugadores) {
                    if (jugadores) {
                        getFecha(function (fecha) {
                            if (fecha) {
                                const doc2 = generarPDFFullBoxScore(jugadores);
                                doc2.save(idlocal + 'vs' + idvisitante +'(' + fecha + ')-(BoxScore).pdf');
                            } else {
                                console.log("Error al obtener la fecha");
                            }
                        });
                    } else {
                    console.log("Error al obtener los jugadores");
                    }
                });
            });


  
        //Botón 3: Mostrar PDF Con todo el JUGADA A JUGADA (CORRECTO)

            var playbyplay = document.createElement('button');
            playbyplay.classList.add('playbyplay');
            playbyplay.innerHTML = 'Jugada a Jugada PDF';
            ventana.appendChild(playbyplay);
            
            playbyplay.addEventListener('click', function() {
                getFecha(function (fecha) {
                    if (fecha) {
                        const doc3 = generarPDFplaybyplay();
                        doc3.save(idlocal + 'vs' + idvisitante +'(' + fecha + ')-(PlayByPlay).pdf');
                    } else {
                        console.log("Error al obtener la fecha");
                    }
                });
                // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
            });

        //Botón 5: Mostrar Impacto TimeOut (CORRECTO)

            var impactoTimeOut = document.createElement('button');
            impactoTimeOut.classList.add('impactoTimeOut');
            impactoTimeOut.innerHTML = 'Impacto Time Out';
            ventana.appendChild(impactoTimeOut);

            impactoTimeOut.addEventListener('click', function() {
            // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
                getParcialTO(function(parcial) {
                    if (parcial) {
                    mostrarImpactoLastTimeOut(parcial);
                    } else {
                    console.log("Error al obtener el parcial");
                    }
                });
            });

        //Botón 6: Mostrar Impacto Cambio (CORRECTO)

            var impactoCambio = document.createElement('button');
            impactoCambio.classList.add('impactoCambio');
            impactoCambio.innerHTML = 'Impacto Cambios';
            ventana.appendChild(impactoCambio);

            impactoCambio.addEventListener('click', function() {
                // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
                getParcialCambio(function(parcial) {
                    if (parcial) {
                    mostrarImpactoLastChange(parcial);
                    } else {
                    console.log("Error al obtener el parcial");
                    }
                });
            });

        //Botón 7: Mostrar PDF con Evaluación X Jugador (CORRECTO)

            var evaluacionplayer = document.createElement('button');
            evaluacionplayer.classList.add('evaluacionplayer');
            evaluacionplayer.innerHTML = 'Evaluación Jugador';
            ventana.appendChild(evaluacionplayer);

            evaluacionplayer.addEventListener('click', function() {
                // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);

                getJugadoresLocal(function(jugadores) {
                    if (jugadores) {
                        console.log(jugadores);
                        evaluacionJugadores(jugadores);
            
                    } else {
                    console.log("Error al obtener los jugadores");
                    }
                });
            });

        //Botón 8: Mostrar PDF con Evaluación X Equipo (CORRECTO)

            var evaluacionequipo = document.createElement('button');
            evaluacionequipo.classList.add('evaluacionequipo');
            evaluacionequipo.innerHTML = 'Evaluación Equipo';
            ventana.appendChild(evaluacionequipo);

            evaluacionequipo.addEventListener('click', function() {
                // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);

                getEquipos(function(equipo) {
                    if (equipo) {
                        getEvaluacionEquipo(function(evaluacion) {
                            if (evaluacion) {
                                mostrarEvaluacionEquipo(evaluacion);
                            } else {
                                console.log("Error al obtener la evaluacion");
                            }
                        }, equipo);   
            
                    } else {
                    console.log("Error al obtener los jugadores");
                    }
                });
            });

        //Botón 9: CAMBIOS SUGERIDOS

            var cambiossugeridos = document.createElement('button');
            cambiossugeridos.classList.add('cambiossugeridos');
            cambiossugeridos.innerHTML = 'CAMBIOS SUGERIDOS';
            ventana.appendChild(cambiossugeridos);

            cambiossugeridos.addEventListener('click', function() {
            // Eliminar tanto la ventana emergente como la capa de fondo oscuro del DOM
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
                cambiossugeridosporfactor(idlocal);
            });

    });

    async function generarPDFS() {
    
        try {
            const jugadoresEstadisticas = await new Promise((resolve, reject) => {
                getJugadoresEstadisticas(function (jugadores) {
                    if (jugadores) {
                        resolve(jugadores);
                    } else {
                        reject(new Error("Error al obtener los jugadores"));
                    }
                });
            });
    
            const equiposEstadisticas = await new Promise((resolve, reject) => {
                getEquiposEstadisticas(function (equipos) {
                    if (equipos) {
                        resolve(equipos);
                    } else {
                        reject(new Error("Error al obtener los equipos"));
                    }
                });
            });
    
            const jugadores = await new Promise((resolve, reject) => {
                getJugadores(function (jugadores) {
                    if (jugadores) {
                        resolve(jugadores);
                    } else {
                        reject(new Error("Error al obtener los jugadores"));
                    }
                });
            });

            const fecha = await new Promise((resolve, reject) => {
                getFecha(function (fecha) {
                    if (fecha) {
                        resolve(fecha);
                    } else {
                        reject(new Error("Error al obtener la fecha"));
                    }
                });
            });

            const doc1 = generarPDFestadisticaCompleta(jugadoresEstadisticas,equiposEstadisticas);
            const doc2 = generarPDFFullBoxScore(jugadores);    
            const doc3 = generarPDFplaybyplay();
    
            doc1.save(idlocal + 'vs' + idvisitante +'(' + fecha + ')-(Stats).pdf');
            doc2.save(idlocal + 'vs' + idvisitante +'(' + fecha + ')-(BoxScore).pdf');
            doc3.save(idlocal + 'vs' + idvisitante +'(' + fecha + ')-(PlayByPlay).pdf');

        } catch (error) {
            console.log(error.message);
        }
    } 

    function mostrarEstadisticaCompleta(jugadores,equipos) {

        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);
    
        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-graficos2");
        document.body.appendChild(ventana);
        
        var localfullTable = document.createElement('table');
        var visitfullTable = document.createElement('table');

        //EQUIPOS

        // Crear la  fila para las cabeceras
        var localfullTeamHeaderRow = localfullTable.insertRow();
        var visitfullTeameaderRow = visitfullTable.insertRow();
    

        var headersTeam = [
            'Equipo',
            'Time', 
            '+/-', 
            'PTS',
            'T2A',
            'T2%',
            'T3A',
            'T3%',
            'TCA',
            'TC%',
            'TLA',
            'TL%',
            'FLH',
            'FLR',
            'TEC',
            'RBO',
            'RBD',
            'RBT',
            'ROB',
            'TAP',
            'PRD',
            'AST',
            'PTQ1',
            'PTQ2',
            'PTQ3',
            'PTQ4',
            'PTQE',
            'T2%Us',
            'T3%Us',
            'TL%Us',
            'eFG%',
            'TO%',
            'TL%',
            'TS%',
            'AS%',
            'POS',
            'OER',
            'DER',
            'PACE'
        ];
          
        for (var i = 0; i < headersTeam.length; i++) {
            var localfullTeamHeaderCell = localfullTeamHeaderRow.insertCell();
            localfullTeamHeaderCell.innerHTML = headersTeam[i];
    
            var visitfullTeameaderCell = visitfullTeameaderRow.insertCell();
            visitfullTeameaderCell.innerHTML = headersTeam[i];
        }

        var equipoLocal = equipos[0];

        var equipovisitante = equipos[1];

        var localTeamfullRow = document.createElement('tr');

        var visitTeamfullRow = document.createElement('tr');

        //Celdas:

        //Local:
        // Crear las celdas para los datos del equipo
        var localfullTeamCell = localTeamfullRow.insertCell();
        localfullTeamCell.innerHTML = equipoLocal.equipo;

        var MTT = localTeamfullRow.insertCell();
        MTT.innerHTML = equipoLocal.MTT;

        var MSMS = localTeamfullRow.insertCell();
        MSMS.innerHTML = equipoLocal.MSMS;

        var PPP = localTeamfullRow.insertCell();
        PPP.innerHTML = equipoLocal.PPP;

        var T2A = localTeamfullRow.insertCell();
        T2A.innerHTML = equipoLocal.T2A;

        var T2P = localTeamfullRow.insertCell();
        T2P.innerHTML = '(' + equipoLocal.T2A + ':' + equipoLocal.T2F + ') - ' + equipoLocal.T2P + '%';

        var T3A = localTeamfullRow.insertCell();
        T3A.innerHTML = equipoLocal.T3A;

        var T3P = localTeamfullRow.insertCell();
        T3P.innerHTML = '(' + equipoLocal.T3A + ':' + equipoLocal.T3F + ') - ' + equipoLocal.T3P + '%';
        
        var TCA = localTeamfullRow.insertCell();
        TCA.innerHTML = equipoLocal.TCA;

        var TCP = localTeamfullRow.insertCell();
        TCP.innerHTML = '(' + equipoLocal.TCA + ':' + equipoLocal.TCF + ') - ' + equipoLocal.TCP + '%';

        var TLA = localTeamfullRow.insertCell();
        TLA.innerHTML = equipoLocal.TLA;

        var TLP = localTeamfullRow.insertCell();
        TLP.innerHTML = '(' + equipoLocal.TLA + ':' + equipoLocal.TLF + ') - ' + equipoLocal.TLP + '%';

        var FLH = localTeamfullRow.insertCell();
        FLH.innerHTML = equipoLocal.FLH;

        var FLR = localTeamfullRow.insertCell();
        FLR.innerHTML = equipoLocal.FLR;

        var TEC = localTeamfullRow.insertCell();
        TEC.innerHTML = equipoLocal.TEC;

        var REB = localTeamfullRow.insertCell();
        REB.innerHTML = equipoLocal.REB;

        var RBO = localTeamfullRow.insertCell();
        RBO.innerHTML = equipoLocal.RBO;

        var RBD = localTeamfullRow.insertCell();
        RBD.innerHTML = equipoLocal.RBD;

        var ROB = localTeamfullRow.insertCell();
        ROB.innerHTML = equipoLocal.ROB;

        var TAP = localTeamfullRow.insertCell();
        TAP.innerHTML = equipoLocal.TAP;

        var PRD = localTeamfullRow.insertCell();
        PRD.innerHTML = equipoLocal.PRD;

        var AST = localTeamfullRow.insertCell();
        AST.innerHTML = equipoLocal.AST;

        var PTQ1 = localTeamfullRow.insertCell();
        PTQ1.innerHTML = equipoLocal.PTQ1;

        var PTQ2 = localTeamfullRow.insertCell();
        PTQ2.innerHTML = equipoLocal.PTQ2;

        var PTQ3 = localTeamfullRow.insertCell();
        PTQ3.innerHTML = equipoLocal.PTQ3;

        var PTQ4 = localTeamfullRow.insertCell();
        PTQ4.innerHTML = equipoLocal.PTQ4;

        var PTQE = localTeamfullRow.insertCell();
        PTQE.innerHTML = equipoLocal.PTQE;

        var T2PU = localTeamfullRow.insertCell();
        T2PU.innerHTML = equipoLocal.T2PU;

        var T3PU = localTeamfullRow.insertCell();
        T3PU.innerHTML = equipoLocal.T3PU;

        var T1PU = localTeamfullRow.insertCell();
        T1PU.innerHTML = equipoLocal.T1PU;

        var eFGP = localTeamfullRow.insertCell();
        eFGP.innerHTML = equipoLocal.eFGP;

        var TOP = localTeamfullRow.insertCell();
        TOP.innerHTML = equipoLocal.TOP;

        var TLP = localTeamfullRow.insertCell();
        TLP.innerHTML = equipoLocal.TLP;

        var TSP = localTeamfullRow.insertCell();
        TSP.innerHTML = equipoLocal.TSP;

        var ASP = localTeamfullRow.insertCell();
        ASP.innerHTML = equipoLocal.ASP;

        var POS = localTeamfullRow.insertCell();
        POS.innerHTML = equipoLocal.POS;

        var OER = localTeamfullRow.insertCell();
        OER.innerHTML = equipoLocal.OER;

        var DER = localTeamfullRow.insertCell();
        DER.innerHTML = equipoLocal.DER;

        var PACE = localTeamfullRow.insertCell();
        PACE.innerHTML = equipoLocal.PACE;

        //Visitante
        var visitfullTeamCell = visitTeamfullRow.insertCell();
        visitfullTeamCell.innerHTML = equipovisitante.equipo;

        var MTT = visitTeamfullRow.insertCell();
        MTT.innerHTML = equipovisitante.MTT;

        var MSMS = visitTeamfullRow.insertCell();
        MSMS.innerHTML = equipovisitante.MSMS;

        var PPP = visitTeamfullRow.insertCell();
        PPP.innerHTML = equipovisitante.PPP;

        var T2A = visitTeamfullRow.insertCell();
        T2A.innerHTML = equipovisitante.T2A;

        var T2P = visitTeamfullRow.insertCell();
        T2P.innerHTML = '(' + equipovisitante.T2A + ':' + equipovisitante.T2F + ') - ' + equipovisitante.T2P + '%';

        var T3A = visitTeamfullRow.insertCell();
        T3A.innerHTML = equipovisitante.T3A;

        var T3P = visitTeamfullRow.insertCell();
        T3P.innerHTML = '(' + equipovisitante.T3A + ':' + equipovisitante.T3F + ') - ' + equipovisitante.T3P + '%';
        
        var TCA = visitTeamfullRow.insertCell();
        TCA.innerHTML = equipovisitante.TCA;

        var TCP = visitTeamfullRow.insertCell();
        TCP.innerHTML = '(' + equipovisitante.TCA + ':' + equipovisitante.TCF + ') - ' + equipovisitante.TCP + '%';

        var TLA = visitTeamfullRow.insertCell();
        TLA.innerHTML = equipovisitante.TLA;

        var TLP = visitTeamfullRow.insertCell();
        TLP.innerHTML = '(' + equipovisitante.TLA + ':' + equipovisitante.TLF + ') - ' + equipovisitante.TLP + '%';

        var FLH = visitTeamfullRow.insertCell();
        FLH.innerHTML = equipovisitante.FLH;

        var FLR = visitTeamfullRow.insertCell();
        FLR.innerHTML = equipovisitante.FLR;

        var TEC = visitTeamfullRow.insertCell();
        TEC.innerHTML = equipovisitante.TEC;

        var REB = visitTeamfullRow.insertCell();
        REB.innerHTML = equipovisitante.REB;

        var RBO = visitTeamfullRow.insertCell();
        RBO.innerHTML = equipovisitante.RBO;

        var RBD = visitTeamfullRow.insertCell();
        RBD.innerHTML = equipovisitante.RBD;

        var ROB = visitTeamfullRow.insertCell();
        ROB.innerHTML = equipovisitante.ROB;

        var TAP = visitTeamfullRow.insertCell();
        TAP.innerHTML = equipovisitante.TAP;

        var PRD = visitTeamfullRow.insertCell();
        PRD.innerHTML = equipovisitante.PRD;

        var AST = visitTeamfullRow.insertCell();
        AST.innerHTML = equipovisitante.AST;

        var PTQ1 = visitTeamfullRow.insertCell();
        PTQ1.innerHTML = equipovisitante.PTQ1;

        var PTQ2 = visitTeamfullRow.insertCell();
        PTQ2.innerHTML = equipovisitante.PTQ2;

        var PTQ3 = visitTeamfullRow.insertCell();
        PTQ3.innerHTML = equipovisitante.PTQ3;

        var PTQ4 = visitTeamfullRow.insertCell();
        PTQ4.innerHTML = equipovisitante.PTQ4;

        var PTQE = visitTeamfullRow.insertCell();
        PTQE.innerHTML = equipovisitante.PTQE;

        var T2PU = visitTeamfullRow.insertCell();
        T2PU.innerHTML = equipovisitante.T2PU;

        var T3PU = visitTeamfullRow.insertCell();
        T3PU.innerHTML = equipovisitante.T3PU;

        var T1PU = visitTeamfullRow.insertCell();
        T1PU.innerHTML = equipovisitante.T1PU;

        var eFGP = visitTeamfullRow.insertCell();
        eFGP.innerHTML = equipovisitante.eFGP;

        var TOP = visitTeamfullRow.insertCell();
        TOP.innerHTML = equipovisitante.TOP;

        var TLP = visitTeamfullRow.insertCell();
        TLP.innerHTML = equipovisitante.TLP;

        var TSP = visitTeamfullRow.insertCell();
        TSP.innerHTML = equipovisitante.TSP;

        var ASP = visitTeamfullRow.insertCell();
        ASP.innerHTML = equipovisitante.ASP;

        var POS = visitTeamfullRow.insertCell();
        POS.innerHTML = equipovisitante.POS;

        var OER = visitTeamfullRow.insertCell();
        OER.innerHTML = equipovisitante.OER;

        var DER = visitTeamfullRow.insertCell();
        DER.innerHTML = equipovisitante.DER;

        var PACE = visitTeamfullRow.insertCell();
        PACE.innerHTML = equipovisitante.PACE;


        localfullTable.appendChild(localTeamfullRow);

        visitfullTable.appendChild(visitTeamfullRow);
        


        //JUGADORES

        // Crear la segunda fila para las cabeceras
        var localfullHeaderRow = localfullTable.insertRow();
        var visitfullHeaderRow = visitfullTable.insertRow();
    
        var headers = [
            'Nº', 
            'Nombre', 
            'Titular', 
            'Time', 
            '+/-', 
            'PTS',
            'T2A',
            'T2%',
            'T3A',
            'T3%',
            'TCA',
            'TC%',
            'TLA',
            'TL%',
            'FLH',
            'FLR',
            'TEC',
            'RBO',
            'RBD',
            'RBT',
            'ROB',
            'TAP',
            'PRD',
            'AST',
            'PTQ1',
            'PTQ2',
            'PTQ3',
            'PTQ4',
            'PTQE',
            'T2%Us',
            'T3%Us',
            'TL%Us',
            'eFG%',
            'TS%',
            'AS%',
            'GS',
            'VAL'
        ];
          
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

            //Creo la línea
            var playerfullRow = document.createElement('tr');
    
            // Crear las celdas para los datos del jugador
            var numero = playerfullRow.insertCell();
            numero.innerHTML = jugador.numero;

            var nombrejugador = playerfullRow.insertCell();
            nombrejugador.innerHTML = jugador.nombrejugador;

            var TIT = playerfullRow.insertCell();
            TIT.innerHTML = jugador.TIT;

            var MTT = playerfullRow.insertCell();
            MTT.innerHTML = jugador.MTT;

            var MSMS = playerfullRow.insertCell();
            MSMS.innerHTML = jugador.MSMS;

            var PTS = playerfullRow.insertCell();
            PTS.innerHTML = jugador.PTS;

            var T2A = playerfullRow.insertCell();
            T2A.innerHTML = jugador.T2A;

            var T2P = playerfullRow.insertCell();
            T2P.innerHTML = '(' + jugador.T2A + ':' + jugador.T2F + ') - ' + jugador.T2P + '%';

            var T3A = playerfullRow.insertCell();
            T3A.innerHTML = jugador.T3A;

            var T3P = playerfullRow.insertCell();
            T3P.innerHTML = '(' + jugador.T3A + ':' + jugador.T3F + ') - ' + jugador.T3P + '%';
            
            var TCA = playerfullRow.insertCell();
            TCA.innerHTML = jugador.TCA;

            var TCP = playerfullRow.insertCell();
            TCP.innerHTML = '(' + jugador.TCA + ':' + jugador.TCF + ') - ' + jugador.TCP + '%';

            var TLA = playerfullRow.insertCell();
            TLA.innerHTML = jugador.TLA;

            var TLP = playerfullRow.insertCell();
            TLP.innerHTML = '(' + jugador.TLA + ':' + jugador.TLF + ') - ' + jugador.TLP + '%';

            var FLH = playerfullRow.insertCell();
            FLH.innerHTML = jugador.FLH;

            var FLR = playerfullRow.insertCell();
            FLR.innerHTML = jugador.FLR;

            var TEC = playerfullRow.insertCell();
            TEC.innerHTML = jugador.TEC;

            var REB = playerfullRow.insertCell();
            REB.innerHTML = jugador.REB;

            var RBO = playerfullRow.insertCell();
            RBO.innerHTML = jugador.RBO;

            var RBD = playerfullRow.insertCell();
            RBD.innerHTML = jugador.RBD;

            var ROB = playerfullRow.insertCell();
            ROB.innerHTML = jugador.ROB;

            var TAP = playerfullRow.insertCell();
            TAP.innerHTML = jugador.TAP;

            var PRD = playerfullRow.insertCell();
            PRD.innerHTML = jugador.PRD;

            var AST = playerfullRow.insertCell();
            AST.innerHTML = jugador.AST;

            var PTQ1 = playerfullRow.insertCell();
            PTQ1.innerHTML = jugador.PTQ1;

            var PTQ2 = playerfullRow.insertCell();
            PTQ2.innerHTML = jugador.PTQ2;

            var PTQ3 = playerfullRow.insertCell();
            PTQ3.innerHTML = jugador.PTQ3;

            var PTQ4 = playerfullRow.insertCell();
            PTQ4.innerHTML = jugador.PTQ4;

            var PTQE = playerfullRow.insertCell();
            PTQE.innerHTML = jugador.PTQE;

            var T2PU = playerfullRow.insertCell();
            T2PU.innerHTML = jugador.T2PU;

            var T3PU = playerfullRow.insertCell();
            T3PU.innerHTML = jugador.T3PU;

            var T1PU = playerfullRow.insertCell();
            T1PU.innerHTML = jugador.T1PU;

            var eFGP = playerfullRow.insertCell();
            eFGP.innerHTML = jugador.eFGP;

            var TSP = playerfullRow.insertCell();
            TSP.innerHTML = jugador.TSP;

            var ASP = playerfullRow.insertCell();
            ASP.innerHTML = jugador.ASP;

            var GS = playerfullRow.insertCell();
            GS.innerHTML = jugador.GS;

            var VAL = playerfullRow.insertCell();
            VAL.innerHTML = jugador.VAL;

            if (isLocal(jugador.equipo)) {
                localfullTable.appendChild(playerfullRow);
            } else {
                visitfullTable.appendChild(playerfullRow);
            }
        }
    
        // Crear la ventana emergente y agregarla al cuerpo del documento
        var displaytablas = document.createElement("div");
        displaytablas.classList.add("displaytablasCompletas");
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

    function generarPDFestadisticaCompleta(jugadores, equipos) {

        // Crear una nueva instancia de jsPDF
        const doc = new jsPDF({
            orientation: 'landscape'
        });
    
        // Definir las posiciones iniciales para el contenido
        let xPosition = 15;
        let yPosition = 15;

        // Añadir el título del equipo local y visitante al PDF
        doc.setFontSize(18);
        doc.setFontStyle('bold');
        doc.text(xPosition, yPosition, 'Partido: ' + idlocal + ' vs ' + idvisitante);
        yPosition += 10;
    
        // Crear la cabecera de la tabla para los equipos
        const headersTeam = [
            'TEAM', 'MTS', 'MSMS', 'PTS', 'T2A', 'T2%', 'T3A', 'T3%', 'TCA', 'TC%',
            'TLA', 'TL%', 'FLH', 'FLR', 'TEC', 'RBO', 'RBD', 'RBT', 'ROB', 'TAP',
            'PRD', 'AST', 'PTQ1', 'PTQ2', 'PTQ3', 'PTQ4', 'PTQE', 'T2%Us', 'T3%Us',
            'TL%Us', 'eFG%', 'TO%', 'TL%', 'TS%', 'AS%', 'POS', 'OER', 'DER', 'PACE'
        ];
    
        doc.autoTable({
            startY: yPosition,
            head: [headersTeam],
            body: [[
                equipos[0].equipo, equipos[0].MTT, equipos[0].MSMS, equipos[0].PPP,
                equipos[0].T2A, equipos[0].T2P + '%',
                equipos[0].T3A, equipos[0].T3P + '%',
                equipos[0].TCA, equipos[0].TCP + '%',
                equipos[0].TLA, equipos[0].TLP + '%',
                equipos[0].FLH, equipos[0].FLR, equipos[0].TEC, equipos[0].REB,
                equipos[0].RBO, equipos[0].RBD, equipos[0].ROB, equipos[0].TAP,
                equipos[0].PRD, equipos[0].AST, equipos[0].PTQ1, equipos[0].PTQ2,
                equipos[0].PTQ3, equipos[0].PTQ4, equipos[0].PTQE, equipos[0].T2PU,
                equipos[0].T3PU, equipos[0].T1PU, equipos[0].eFGP, equipos[0].TOP,
                equipos[0].TLP, equipos[0].TSP, equipos[0].ASP, equipos[0].POS,
                equipos[0].OER, equipos[0].DER, equipos[0].PACE
            ], [
                equipos[1].equipo, equipos[1].MTT, equipos[1].MSMS, equipos[1].PPP,
                equipos[1].T2A, equipos[1].T2P + '%',
                equipos[1].T3A, equipos[1].T3P + '%',
                equipos[1].TCA, equipos[1].TCP + '%',
                equipos[1].TLA, equipos[1].TLP + '%',
                equipos[1].FLH, equipos[1].FLR, equipos[1].TEC, equipos[1].REB,
                equipos[1].RBO, equipos[1].RBD, equipos[1].ROB, equipos[1].TAP,
                equipos[1].PRD, equipos[1].AST, equipos[1].PTQ1, equipos[1].PTQ2,
                equipos[1].PTQ3, equipos[1].PTQ4, equipos[1].PTQE, equipos[1].T2PU,
                equipos[1].T3PU, equipos[1].T1PU, equipos[1].eFGP, equipos[1].TOP,
                equipos[1].TLP, equipos[1].TSP, equipos[1].ASP, equipos[1].POS,
                equipos[1].OER, equipos[1].DER, equipos[1].PACE
            ]],
            styles: { fontSize: 6, fontStyle: 'helvetica'},
            headStyles: { fillColor: [0, 0, 0], textColor: [255, 255, 255] },
        });
    
        yPosition = doc.previousAutoTable.finalY + 10;
    
        // Crear la cabecera de la tabla para los jugadores
        const headersJugadores = [
            'NO', 'Nombre', 'TITL', 'MTS', 'MSMS', 'PTS', 'T2A', 'T2%', 'T3A', 'T3%',
            'TCA', 'TC%', 'TLA', 'TL%', 'FLH', 'FLR', 'TEC', 'RBO', 'RBD','ROB',
            'TAP', 'PRD', 'AST', 'PTQ1', 'PTQ2', 'PTQ3', 'PTQ4', 'PTQE', 'T2%Us', 'T3%Us',
            'TL%Us', 'eFG%', 'TS%', 'AS%', 'GS', 'VAL'
        ];
    
        doc.autoTable({
            startY: yPosition,
            head: [headersJugadores],
            body: jugadores.map(jugador => [
                jugador.numero, jugador.nombrejugador, jugador.TIT, jugador.MTT,
                jugador.MSMS, jugador.PTS,
                jugador.T2A, jugador.T2P + '%',
                jugador.T3A, jugador.T3P + '%',
                jugador.TCA, jugador.TCP + '%',
                jugador.TLA, jugador.TLP + '%',
                jugador.FLH, jugador.FLR, jugador.TEC, jugador.RBO,
                jugador.RBD, jugador.ROB, jugador.TAP, jugador.PRD,
                jugador.AST, jugador.PTQ1, jugador.PTQ2, jugador.PTQ3,
                jugador.PTQ4, jugador.PTQE, jugador.T2PU, jugador.T3PU,
                jugador.T1PU, jugador.eFGP, jugador.TSP, jugador.ASP,
                jugador.GS, jugador.VAL
            ]),
            styles: { fontSize: 6, fontStyle: 'helvetica'},
            headStyles: { fillColor: [0, 0, 0], textColor: [255, 255, 255] },
        });

        return doc;
    }
    
    function generarPDFFullBoxScore(jugadores) {

        // Crear una nueva instancia de jsPDF
        const doc = new jsPDF();
    
        // Definir las posiciones iniciales para el contenido
        let xPosition = 15;
        let yPosition = 15;
    
        
        // Añadir el título del equipo local y visitante al PDF
        doc.setFontSize(18);
        doc.setFontStyle('bold');
        doc.text(xPosition, yPosition, 'Partido: ' + idlocal + ' vs ' + idvisitante);
        yPosition += 10;

        // Añadir el título del equipo local y visitante al PDF
        doc.setFontSize(18);
        doc.setFontStyle('bold');
        doc.text(xPosition, yPosition, idlocal);
        yPosition += 10;
    
        // Añadir la tabla de jugadores del equipo local al PDF
        doc.autoTable({
            head: [['Nº', 'Nombre', 'Ptos.', 'Faltas', 'Time']],
            body: getPlayersData(jugadores), // Obtener los datos de los jugadores del equipo local
            startY: yPosition,
        });
    
        // Añadir el título del equipo visitante al PDF
        yPosition = doc.lastAutoTable.finalY + 10;
        doc.text(xPosition, yPosition, idvisitante);
        yPosition += 10;
    
        // Añadir la tabla de jugadores del equipo visitante al PDF
        doc.autoTable({
            head: [['Nº', 'Nombre', 'Ptos.', 'Faltas', 'Time']],
            body: getPlayersDataV(jugadores), // Obtener los datos de los jugadores del equipo visitante
            startY: yPosition,
        });

        return doc;
    }
    
    function getPlayersData(jugadores) {
        return jugadores
            .filter(jugador => isLocal(jugador.equipo))
            .map(jugador => {
                const puntosPlayer = (jugador.T2A * 2) + (jugador.T3A * 3) + (jugador.TLA * 1);
                const faltasPlayer = jugador.FLH;
                const minutosjugador = Math.floor(jugador.MT / 60);
                const segundosjugador = jugador.MT % 60;
                const minutosPlayer = `${minutosjugador.toString().padStart(2, '0')}:${segundosjugador.toString().padStart(2, '0')}`;
    
                return [jugador.numero, jugador.nombrejugador, puntosPlayer, faltasPlayer, minutosPlayer];
            });
    }

    function getPlayersDataV(jugadores) {
        return jugadores
            .filter(jugador => !isLocal(jugador.equipo))
            .map(jugador => {
                const puntosPlayer = (jugador.T2A * 2) + (jugador.T3A * 3) + (jugador.TLA * 1);
                const faltasPlayer = jugador.FLH;
                const minutosjugador = Math.floor(jugador.MT / 60);
                const segundosjugador = jugador.MT % 60;
                const minutosPlayer = `${minutosjugador.toString().padStart(2, '0')}:${segundosjugador.toString().padStart(2, '0')}`;
    
                return [jugador.numero, jugador.nombrejugador, puntosPlayer, faltasPlayer, minutosPlayer];
            });
    }
    
    function generarPDFplaybyplay() {

        // Obtener el contenido del div
        const divContent = document.querySelector('.info-display');

        // Obtener el contenido dividido por líneas
        const lines = divContent.innerHTML.split('<br>').map(line => line.trim()).filter(line => line !== '');
        
        // Crear una nueva instancia de jsPDF
        const doc = new jsPDF();

        // Definir las posiciones iniciales para el contenido
        let xPosition = 15;
        let yPosition = 15;

        // Calcular la altura total del contenido para ajustar la posición en "y"
        const lineHeight = 6; 
        const totalHeight = lines.length * lineHeight;

        // Verificar si el contenido se ajusta en una sola página o requiere varias páginas

        const pageWidth = 210; // Ancho de la página A4 en mm
        const pageHeight = 297; // Altura de la página A4 en mm

        // Configurar los márgenes
        const pageMargin = 15; // Margen superior, inferior y derecho de la página en mm
        
        const availableWidth = pageWidth - pageMargin * 2;
        const availableHeight = pageHeight - pageMargin * 2;
        
        const requireMultiplePages = totalHeight > availableHeight;

        // Función para agregar una página nueva al PDF y restablecer las coordenadas

        function newPage() {
            doc.addPage();

            doc.setFontSize(18); // Restaurar el tamaño de fuente para el título en nuevas páginas
            doc.setFontStyle('bold'); // Restaurar el estilo de fuente para el título en nuevas páginas

            // Definir las posiciones iniciales para el contenido
            xPosition = 15;
            yPosition = 15;

            doc.text(xPosition, yPosition, 'Partido: ' + idlocal + ' vs ' + idvisitante); // Agregar el título en la nueva página

            // Restaurar el estilo de fuente por defecto (opcional)
            doc.setFontSize(12); // Tamaño de fuente por defecto
            doc.setFontStyle('normal'); // Estilo de fuente por defecto

            yPosition += lineHeight; // Aumentar la posición en "y" para la siguiente línea
        }


        // Añadir el título al PDF
        doc.setFontSize(18); // Tamaño de fuente para el título
        doc.setFontStyle('bold'); // Estilo de fuente para el título (negrita)
        doc.text(xPosition, yPosition, 'Partido: ' + idlocal + 'vs' + idvisitante); // Agregar el título en la posición (15, 15)

        yPosition = 15 + lineHeight; // Restablecer la posición en "y" para el contenido

        // Restaurar el estilo de fuente por defecto (opcional)
        doc.setFontSize(12); // Tamaño de fuente por defecto
        doc.setFontStyle('normal'); // Estilo de fuente por defecto

        // Agregar cada línea al PDF con un salto de línea
        lines.forEach((line, index) => {
            if (requireMultiplePages && yPosition + lineHeight > pageHeight - pageMargin) {
            // Si el contenido no cabe en la página actual, agregar una nueva página
            newPage();
            }

            doc.text(15, yPosition, line);
            yPosition += lineHeight; // Aumentar la posición en "y" para la siguiente línea

        });

        return doc;

    }

    function getJugadoresporFactor(callback,factor,equipo) {
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
            console.log("La respuesta está completa.");
            // La respuesta ha sido recibida
            var jugadores = JSON.parse(this.responseText);
            console.log(jugadores);
            callback(jugadores); // Llamar a la devolución de llamada con los jugadores
        } else {
            console.log("La respuesta está vacía o incompleta.");
            callback(null); // Llamar a la devolución de llamada con valor nulo
        }
        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "getJugadoresporFactor.php?factor=" + factor + "&equipo=" + equipo, true);
    xhttp.send();
    }

    function getEvaluacionJugador(callback,jugador) {

    // Convertir el objeto jugador a una cadena JSON
    var jugadorJSON = JSON.stringify(jugador);

    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
            console.log("La respuesta está completa.");
            // La respuesta ha sido recibida
            var evaluaciones = JSON.parse(this.responseText);
            console.log(evaluaciones);
            callback(evaluaciones); // Llamar a la devolución de llamada con los jugadores
        } else {
            console.log("La respuesta está vacía o incompleta.");
            callback(null); // Llamar a la devolución de llamada con valor nulo
        }
        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "getEvaluacionJugador.php?jugador=" + encodeURIComponent(jugadorJSON), true);
    xhttp.send();
    }

    function getEvaluacionEquipo(callback,equipo) {

        var equipoJSON = JSON.stringify(equipo);
    
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();
    
        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            if (this.responseText) {
                console.log("La respuesta está completa.");
                // La respuesta ha sido recibida
                var evaluaciones = JSON.parse(this.responseText);
                console.log(evaluaciones);
                callback(evaluaciones); // Llamar a la devolución de llamada con los jugadores
            } else {
                console.log("La respuesta está vacía o incompleta.");
                callback(null); // Llamar a la devolución de llamada con valor nulo
            }
            }
        };
    
        // Hacer la solicitud AJAX
        xhttp.open("GET", "getEvaluacionEquipo.php?equipo=" + encodeURIComponent(equipoJSON), true);
        xhttp.send();
    }

    function getJugadoresEquipo(callback,equipo) {

        var equipoJSON = JSON.stringify(equipo);
    
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();
    
        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            if (this.responseText) {
                console.log("La respuesta está completa.");
                // La respuesta ha sido recibida
                var jugadores = JSON.parse(this.responseText);
                console.log(jugadores);
                callback(jugadores); // Llamar a la devolución de llamada con los jugadores
            } else {
                console.log("La respuesta está vacía o incompleta.");
                callback(null); // Llamar a la devolución de llamada con valor nulo
            }
            }
        };
    
        // Hacer la solicitud AJAX
        xhttp.open("GET", "getJugadoresEquipo.php?equipo=" + encodeURIComponent(equipoJSON), true);
        xhttp.send();
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

    function getJugadoresEstadisticas(callback) {
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
        xhttp.open("GET", "getJugadoresEstadisticas.php", true);
        xhttp.send();
    }

    function getEquipos(callback) {
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();
    
        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            if (this.responseText) {
                console.log("La respuesta está completa.");
                // La respuesta ha sido recibida
                var equipos = JSON.parse(this.responseText);
                callback(equipos); // Llamar a la devolución de llamada con los jugadores
            } else {
                console.log("La respuesta está vacía o incompleta.");
                callback(null); // Llamar a la devolución de llamada con valor nulo
            }
            }
        };
    
        // Hacer la solicitud AJAX
        xhttp.open("GET", "getEquipos.php", true);
        xhttp.send();
    }

    function getEquiposEstadisticas(callback) {
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();
    
        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            if (this.responseText) {
                console.log("La respuesta está completa.");
                // La respuesta ha sido recibida
                var equipos = JSON.parse(this.responseText);
                callback(equipos); // Llamar a la devolución de llamada con los jugadores
            } else {
                console.log("La respuesta está vacía o incompleta.");
                callback(null); // Llamar a la devolución de llamada con valor nulo
            }
            }
        };
    
        // Hacer la solicitud AJAX
        xhttp.open("GET", "getEquiposEstadisticas.php", true);
        xhttp.send();
    }

    function getJugadoresLocal(callback) {
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
    xhttp.open("GET", "getJugadoresLocal.php?equipo=" + idlocal, true);
    xhttp.send();
    }

    function getFecha(callback) {
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();
    
        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            if (this.responseText) {
                console.log("La respuesta está completa.");
                // La respuesta ha sido recibida
                var fecha = JSON.parse(this.responseText);
                callback(fecha); // Llamar a la devolución de llamada con los jugadores
            } else {
                console.log("La respuesta está vacía o incompleta.");
                callback(null); // Llamar a la devolución de llamada con valor nulo
            }
            }
        };
    
        // Hacer la solicitud AJAX
        xhttp.open("GET", "getFecha.php?partido_id=" + parseInt(idpartidoElement.textContent), true);
        xhttp.send();
    }

    function getParcialTO(callback) {
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
            console.log("La respuesta está completa.");
            // La respuesta ha sido recibida
            var parcial = JSON.parse(this.responseText);
            callback(parcial); // Llamar a la devolución de llamada con el parcial
        } else {
            console.log("La respuesta está vacía o incompleta.");
            callback(null); // Llamar a la devolución de llamada con valor nulo
        }
        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "getParcialTO.php", true);
    xhttp.send();
    }

    function getParcialCambio(callback) {
    // Crear una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función de respuesta
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
            console.log("La respuesta está completa.");
            // La respuesta ha sido recibida
            var parcial = JSON.parse(this.responseText);
            callback(parcial); // Llamar a la devolución de llamada con el parcial
        } else {
            console.log("La respuesta está vacía o incompleta.");
            callback(null); // Llamar a la devolución de llamada con valor nulo
        }
        }
    };

    // Hacer la solicitud AJAX
    xhttp.open("GET", "getParcialCambio.php", true);
    xhttp.send();
    }

    function mostrarVentanaEliminarAccionJugador(jugadores){

        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-graficos");
        document.body.appendChild(ventana);
        
        var mensaje = document.createElement('h1');
        mensaje.textContent = `De qué jugador quieres eliminar una accion:`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');


        // Crear una tabla para la lista de jugadores
        var tabla = document.createElement("table");
        contador = 0;

        for(var j = 0; j < Math.ceil(jugadores.length/3);j++){

            var tr = document.createElement("tr");
        
            contadorFila = 0;
        
            while(contador < jugadores.length && contadorFila < 4){
              var jugador = jugadores[contador];
              contador++;
      
              var td = document.createElement("td");
              var boton = document.createElement("button");
      
              boton.textContent = jugador.numero + '-' + jugador.nombrejugador;
      
              boton.addEventListener("click", eliminarAccionJugador(jugador));
      
              td.appendChild(boton);
              tr.appendChild(td);
      
              contadorFila++;
            }
        
            tabla.appendChild(tr);
        }

        ventana.appendChild(tabla);

        // Función para crear el evento click con el valor del jugador como argumento
        function eliminarAccionJugador(jugador){
            return function() {
                console.log(jugador)
                mostrarVentanaEliminarAccion(jugador);
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
            }
        }

        // Agregar el contenido a la ventana emergente
        ventana.appendChild(contenido);

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

    function mostrarVentanaEliminarAccion(jugador){

        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);
        
        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-factor");
        document.body.appendChild(ventana);

        var mensaje = document.createElement('h1');
        mensaje.textContent = `Qué acción deseas eliminar`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');

        //OK
 
        var botonT2A = document.createElement("button");
        botonT2A.textContent = "T2A";
        botonT2A.addEventListener("click", eliminarAccionJugador("T2A",jugador));
        contenido.appendChild(botonT2A);

        var botonT2F = document.createElement("button");
        botonT2F.textContent = "T2F";
        botonT2F.addEventListener("click", eliminarAccionJugador("T2F",jugador));
        contenido.appendChild(botonT2F);

        var botonT3A = document.createElement("button");
        botonT3A.textContent = "T3A";
        botonT3A.addEventListener("click", eliminarAccionJugador("T3A",jugador));
        contenido.appendChild(botonT3A);

        var botonT3F = document.createElement("button");
        botonT3F.textContent = "T3F";
        botonT3F.addEventListener("click", eliminarAccionJugador("T3F",jugador));
        contenido.appendChild(botonT3F);

        var botonTLA = document.createElement("button");
        botonTLA.textContent = "TLA";
        botonTLA.addEventListener("click", eliminarAccionJugador("TLA",jugador));
        contenido.appendChild(botonTLA);

        var botonTLF = document.createElement("button");
        botonTLF.textContent = "TLF";
        botonTLF.addEventListener("click", eliminarAccionJugador("TLF",jugador));
        contenido.appendChild(botonTLF);

        var botonFLH = document.createElement("button");
        botonFLH.textContent = "FLH";
        botonFLH.addEventListener("click", eliminarAccionJugador("FLH",jugador));
        contenido.appendChild(botonFLH);

        var botonFLR = document.createElement("button");
        botonFLR.textContent = "FLR";
        botonFLR.addEventListener("click", eliminarAccionJugador("FLR",jugador));
        contenido.appendChild(botonFLR);

        var botonTEC = document.createElement("button");
        botonTEC.textContent = "TEC";
        botonTEC.addEventListener("click", eliminarAccionJugador("TEC",jugador));
        contenido.appendChild(botonTEC);

        var botonRBO = document.createElement("button");
        botonRBO.textContent = "RBO";
        botonRBO.addEventListener("click", eliminarAccionJugador("RBO",jugador));
        contenido.appendChild(botonRBO);

        var botonRBD = document.createElement("button");
        botonRBD.textContent = "RBD";
        botonRBD.addEventListener("click", eliminarAccionJugador("RBD",jugador));
        contenido.appendChild(botonRBD);

        var botonROB = document.createElement("button");
        botonROB.textContent = "ROB";
        botonROB.addEventListener("click", eliminarAccionJugador("ROB",jugador));
        contenido.appendChild(botonROB);

        var botonTAP = document.createElement("button");
        botonTAP.textContent = "TAP";
        botonTAP.addEventListener("click", eliminarAccionJugador("TAP",jugador));
        contenido.appendChild(botonTAP);

        var botonPRD = document.createElement("button");
        botonPRD.textContent = "PRD";
        botonPRD.addEventListener("click", eliminarAccionJugador("PRD",jugador));
        contenido.appendChild(botonPRD);

        var botonAST = document.createElement("button");
        botonAST.textContent = "AST";
        botonAST.addEventListener("click", eliminarAccionJugador("AST",jugador));
        contenido.appendChild(botonAST);

        function eliminarAccionJugador(factor,jugador){
            return function() {
                console.log(factor + ' ' + jugador.numero);
                eliminarAccion(jugador,factor,jugador.equipo);           
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
            }
        }
        
        // Agregar el contenido a la ventana emergente
        ventana.appendChild(contenido);
        
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



    function cambiossugeridosporfactor(equipo){
        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);
        
        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-factor");
        document.body.appendChild(ventana);

        var mensaje = document.createElement('h1');
        mensaje.textContent = `Para que factor quieres obtener cambios sugeridos`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');

        //OK

        var botonT2A = document.createElement("button");
        botonT2A.textContent = "T2A";
        botonT2A.addEventListener("click", crearListaCambio("T2A",equipo));
        contenido.appendChild(botonT2A);

        var botonT3A = document.createElement("button");
        botonT3A.textContent = "T3A";
        botonT3A.addEventListener("click", crearListaCambio("T3A",equipo));
        contenido.appendChild(botonT3A);

        var botonTLA = document.createElement("button");
        botonTLA.textContent = "TLA";
        botonTLA.addEventListener("click", crearListaCambio("TLA",equipo));
        contenido.appendChild(botonTLA);

        var botonMSMS = document.createElement("button");
        botonMSMS.textContent = "MSMS";
        botonMSMS.addEventListener("click", crearListaCambio("MSMS",equipo));
        contenido.appendChild(botonMSMS);

        var botonFLH = document.createElement("button");
        botonFLH.textContent = "FLH";
        botonFLH.addEventListener("click", crearListaCambio("FLH",equipo));
        contenido.appendChild(botonFLH);

        var botonFLR = document.createElement("button");
        botonFLR.textContent = "FLR";
        botonFLR.addEventListener("click", crearListaCambio("FLR",equipo));
        contenido.appendChild(botonFLR);

        var botonMT = document.createElement("button");
        botonMT.textContent = "MT";
        botonMT.addEventListener("click", crearListaCambio("MT",equipo));
        contenido.appendChild(botonMT);

        var botonRBO = document.createElement("button");
        botonRBO.textContent = "RBO";
        botonRBO.addEventListener("click", crearListaCambio("RBO",equipo));
        contenido.appendChild(botonRBO);

        var botonRBD = document.createElement("button");
        botonRBD.textContent = "RBD";
        botonRBD.addEventListener("click", crearListaCambio("RBD",equipo));
        contenido.appendChild(botonRBD);

        var botonAST = document.createElement("button");
        botonAST.textContent = "AST";
        botonAST.addEventListener("click", crearListaCambio("AST",equipo));
        contenido.appendChild(botonAST);

        var botonROB = document.createElement("button");
        botonROB.textContent = "ROB";
        botonROB.addEventListener("click", crearListaCambio("ROB",equipo));
        contenido.appendChild(botonROB);

        var botonTAP = document.createElement("button");
        botonTAP.textContent = "TAP";
        botonTAP.addEventListener("click", crearListaCambio("TAP",equipo));
        contenido.appendChild(botonTAP);

        var botonPTQ1 = document.createElement("button");
        botonPTQ1.textContent = "PTQ1";
        botonPTQ1.addEventListener("click", crearListaCambio("PTQ1",equipo));
        contenido.appendChild(botonPTQ1);

        var botonPTQ2 = document.createElement("button");
        botonPTQ2.textContent = "PTQ2";
        botonPTQ2.addEventListener("click", crearListaCambio("PTQ2",equipo));
        contenido.appendChild(botonPTQ2);

        var botonPTQ3 = document.createElement("button");
        botonPTQ3.textContent = "PTQ3";
        botonPTQ3.addEventListener("click", crearListaCambio("PTQ3",equipo));
        contenido.appendChild(botonPTQ3);

        var botonPTQ4 = document.createElement("button");
        botonPTQ4.textContent = "PTQ4";
        botonPTQ4.addEventListener("click", crearListaCambio("PTQ4",equipo));
        contenido.appendChild(botonPTQ4);

        var botonPTQE = document.createElement("button");
        botonPTQE.textContent = "PTQE";
        botonPTQE.addEventListener("click", crearListaCambio("PTQE",equipo));
        contenido.appendChild(botonPTQE);

        //NO OK

        var botonT2P = document.createElement("button");
        botonT2P.textContent = "T2P";
        botonT2P.addEventListener("click", crearListaCambio("T2P",equipo));
        contenido.appendChild(botonT2P);

        var botonT3P = document.createElement("button");
        botonT3P.textContent = "T3P";
        botonT3P.addEventListener("click", crearListaCambio("T3P",equipo));
        contenido.appendChild(botonT3P);

        var botonTLP = document.createElement("button");
        botonTLP.textContent = "TLP";
        botonTLP.addEventListener("click", crearListaCambio("TLP",equipo));
        contenido.appendChild(botonTLP);
        
        var botonPTSP = document.createElement("button");
        botonPTSP.textContent = "PTSP";
        botonPTSP.addEventListener("click", crearListaCambio("PTSP",equipo));
        contenido.appendChild(botonPTSP);

        var botonMSMSP = document.createElement("button");
        botonMSMSP.textContent = "MSMSP";
        botonMSMSP.addEventListener("click", crearListaCambio("MSMSP",equipo));
        contenido.appendChild(botonMSMSP);

        var botonREB = document.createElement("button");
        botonREB.textContent = "REB";
        botonREB.addEventListener("click", crearListaCambio("REB",equipo));
        contenido.appendChild(botonREB);

        var botonVAL = document.createElement("button");
        botonVAL.textContent = "VAL";
        botonVAL.addEventListener("click", crearListaCambio("VAL",equipo));
        contenido.appendChild(botonVAL);

        function crearListaCambio(factor,equipo){
            return function() {
                console.log(factor + ' ' + equipo);
                getJugadoresporFactor(function(jugadores) {
                    if (jugadores) {
                        mostrarListaJugadoresporFactor(jugadores,factor);
                    } else {
                        console.log("Error al obtener los jugadores");
                    }
                    }, factor, equipo);            
                ventana.parentNode.removeChild(ventana);
                overlay.parentNode.removeChild(overlay);
            }
        }
        
        // Agregar el contenido a la ventana emergente
        ventana.appendChild(contenido);
        
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

    function mostrarListaJugadoresporFactor(jugadores,factor){
        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-factor-lista");
        document.body.appendChild(ventana);

        var mensaje = document.createElement('h1');
        mensaje.textContent = `Mejores Cambios según: ${factor}`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');

        // Aquí implemento
        //Ordenar
        jugadores.sort(function(a, b) {
        return (b.factor+b.historico) - (a.factor+a.historico);
        });

        for (var i = 0; i < jugadores.length; i++) {
            var jugador = jugadores[i];
            var elementoJugador = document.createElement('div');
            elementoJugador.textContent = `${jugador.numero}-${jugador.nombrejugador} - ${factor}:${jugador.factor} - H:${jugador.historico} `;
            contenido.appendChild(elementoJugador);
        }
            
        // Agregar el contenido a la ventana emergente
        ventana.appendChild(contenido);

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

    function evaluacionJugadores(jugadores){

        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-graficos");
        document.body.appendChild(ventana);
        
        // Aquí utilizo las comillas inversas para poder interpolación de variables
        var mensaje = document.createElement('h1');
        mensaje.textContent = `De qué jugador quieres una evaluacion:`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');


        // Crear una tabla para la lista de jugadores
        var tabla = document.createElement("table");
        contador = 0;

        for(var j = 0; j < Math.ceil(jugadores.length/3);j++){

            var tr = document.createElement("tr");
        
            contadorFila = 0;
        
            while(contador < jugadores.length && contadorFila < 4){
              var jugador = jugadores[contador];
              contador++;
      
              var td = document.createElement("td");
              var boton = document.createElement("button");
      
              boton.textContent = jugador.numero + '-' + jugador.nombrejugador;
      
              boton.addEventListener("click", crearEvaluacion(jugador));
      
              td.appendChild(boton);
              tr.appendChild(td);
      
              contadorFila++;
            }
        
            tabla.appendChild(tr);
        }

        ventana.appendChild(tabla);

        // Función para crear el evento click con el valor del jugador como argumento
        function crearEvaluacion(jugador){
            return function() {
                console.log(jugador)
                getEvaluacionJugador(function(evaluacion) {
                    if (evaluacion) {
                        mostrarEvaluacionJugador(evaluacion,jugador);
                    } else {
                        console.log("Error al obtener la evaluacion");
                    }
                }, jugador);            
            ventana.parentNode.removeChild(ventana);
            overlay.parentNode.removeChild(overlay);
            }
        }

        // Agregar el contenido a la ventana emergente
        ventana.appendChild(contenido);

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

    function mostrarEvaluacionJugador(evaluacion,jugador){
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

        var mensaje = document.createElement('h1');
        mensaje.textContent = `La evaluación de ${jugador['nombrejugador']} es:`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');

        // Agregar el contenido a la ventana emergente
        for (var clave in evaluacion) {
            var mensaje = document.createElement('p');
            mensaje.textContent = `Su ${clave} es ${evaluacion[clave] === "1" ? 'mayor o igual' : 'menor'} al habitual.`;
            mensaje.style.color = evaluacion[clave] === "1" ? 'green' : 'red';
            contenido.appendChild(mensaje);
        }
     
        ventana.appendChild(contenido);
    }

    function mostrarEvaluacionEquipo(evaluacion){
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

        var mensaje = document.createElement('h1');
        mensaje.textContent = `La evaluación del equipo es:`;
        ventana.appendChild(mensaje);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');

        // Agregar el contenido a la ventana emergente
        for (var clave in evaluacion) {
            var mensaje = document.createElement('p');
            mensaje.textContent = `Su ${clave} es ${evaluacion[clave] === "1" ? 'mayor o igual' : 'menor'} al habitual.`;
            mensaje.style.color = evaluacion[clave] === "1" ? 'green' : 'red';
            contenido.appendChild(mensaje);
        }
     
        ventana.appendChild(contenido);

    }

    function mostrarImpactoLastTimeOut(parcial) {
        // Crear la capa de fondo oscuro y agregarla al DOM
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Crear la ventana emergente y agregarla al cuerpo del documento
        var ventana = document.createElement('div');
        ventana.classList.add("ventana-graficos");
        document.body.appendChild(ventana);

        // Crear el contenido que deseas mostrar en la ventana emergente
        var contenido = document.createElement('div');
        contenido.classList.add('contenido');

        var mensaje = document.createElement('p');
        mensaje.textContent = `El parcial desde el último Tiempo Muerto es:\nLocal ${parcial[0]} - ${parcial[1]} Visitante`;
        contenido.appendChild(mensaje);

        // Agregar el contenido a la ventana emergente
        ventana.appendChild(contenido);

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

    function mostrarImpactoLastChange(parcial) {
    // Crear la capa de fondo oscuro y agregarla al DOM
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Crear la ventana emergente y agregarla al cuerpo del documento
    var ventana = document.createElement('div');
    ventana.classList.add("ventana-graficos");
    document.body.appendChild(ventana);

    // Crear el contenido que deseas mostrar en la ventana emergente
    var contenido = document.createElement('div');
    contenido.classList.add('contenido');

    var mensaje = document.createElement('p');
    mensaje.textContent = `El parcial desde el último Cambio es:\nLocal ${parcial[0]} - ${parcial[1]} Visitante`;
    contenido.appendChild(mensaje);

    // Agregar el contenido a la ventana emergente
    ventana.appendChild(contenido);

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
            var minutosjugador = Math.floor(jugador.MT / 60);
            var segundosjugador = jugador.MT % 60;
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
    
    }

/////////////////////////////////////////////////////////////
/*MARCADOR DE PUNTOS*/
/////////////////////////////////////////////////////////////

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
        }
        else{
            // Actualizar el valor del marcador
            visitpointsElement.textContent = parseInt(visitpointsElement.textContent) + puntos;
        }

        actualizarDatosPuntos(puntos,equipo,jugador);

        if (puntos < 0) {
            // Acción a realizar si puntos es negativo
            mostrarMensajeLogLine("¡Error! Se elimina la canasta de " + puntos + " del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
        } else {
            mostrarMensajeLogLine("Canasta de " + puntos + " del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
        }
    }

    function actualizarDatosPuntos(puntos,equipo,jugador){
        //1º Actualizar más menos de los jugadores
        actualizarMSMS(puntos,equipo);
        // 2º Guardar los puntos en total y 3º Añadir puntos al cuarto
        actualizarpuntoscuarto(jugador,puntos);
        //4º Checkear si hay empate y 5º Checkear alternancia en marcador
        checkmarcador();
        // 6º Parciales??
        parciales(puntos,equipo);
    }

    function actualizarpuntoscuarto(jugador,puntos){

        //Guardar la variable de Puntos Cuarto

        period = document.getElementById("periodSelect").value;

        switch(period){
            case 'Periodo 1':
                cuarto = 1;
                cuartoJugador = "PTQ1"
                break;

            case 'Periodo 2':
                cuarto = 2;
                cuartoJugador = "PTQ2"

                break;

            case 'Periodo 3':
                cuarto = 3;
                cuartoJugador = "PTQ3"

                break;

            case 'Periodo 4':
                cuarto = 4;
                cuartoJugador = "PTQ4"

                break;
            default:
                cuarto = 5;
                cuartoJugador = "PTQE"

            break;
        }

        //LLamar a función de recopilar datos de ese cuarto.
        guardarpuntoscuarto(idlocal,idvisitante,parseInt(localpointsElement.textContent),parseInt(visitpointsElement.textContent),cuarto);
        guardarpuntoscuartoJugador(cuartoJugador,jugador.jugador,puntos);
    }

    //ACTUALIZAR MAS/MENOS
    function actualizarMSMS(puntos,equipo){

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
        xhttp.open("GET", "actualizarMSMS.php?puntos=" + puntos + "&equipo=" + equipo, true);
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

    //ACTUALIZAR PUNTOSCUARTO
    function guardarpuntoscuartoJugador(cuarto,jugador,puntos){

        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();

        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("La respuesta está completa en guardarpuntoscuartoJugador.");
            }
            else{
                console.log("La respuesta está  NO completa en guardarpuntoscuartoJugador.");

            }
        };

        // Hacer la solicitud AJAX
        xhttp.open("GET", "guardarpuntoscuartoJugador.php?cuarto=" + cuarto + "&jugador=" + jugador + "&puntos=" + puntos, true);
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

    //PARCIALES
    function parciales(puntos,equipo){

        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();

        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("La respuesta está completa en parciales.");
            }
            else{
                console.log("La respuesta está  NO completa en parciales.");

            }
        };

        // Hacer la solicitud AJAX
        xhttp.open("GET", "parciales.php?puntos=" + puntos + "&equipo=" + equipo, true);
        xhttp.send();
    }


/////////////////////////////////////////////////////////////
/*TIEMPOS MUERTOS y FALTAS BANQUILLO*/
/////////////////////////////////////////////////////////////

    let timeoutLocal = document.querySelector(".timeout-local .timeout");
    let timeoutVisit = document.querySelector(".timeout-visit .timeout");
    let addTimeoutButtons = document.querySelectorAll(".add-timeout");

    // Obtener el elemento con la clase "buttons-coach-local"
    let localbuttonscoach = document.querySelector('.buttons-coach-local');
    // Obtener el elemento con la clase "timeout" dentro del elemento "buttonscoachlocal"
    let localtimeout = localbuttonscoach.querySelector('.timeoutP');
    // Obtener el elemento con la clase "faltabanquillo" dentro del elemento "buttonscoachlocal"
    let localfaltabanquillo = localbuttonscoach.querySelector('.faltabanquilloP');

    // Obtener el elemento con la clase "buttons-coach-visit"
    let visitbuttonscoach = document.querySelector('.buttons-coach-visit');
    // Obtener el elemento con la clase "timeout" dentro del elemento "buttonscoachlocal"
    let visittimeout = visitbuttonscoach.querySelector('.timeoutP');
    // Obtener el elemento con la clase "faltabanquillo" dentro del elemento "buttonscoachlocal"
    let visitfaltabanquillo = visitbuttonscoach.querySelector('.faltabanquilloP');

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
        xhttp.open("GET", "addtimeout.php?equipo=" + equipo, true);
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
        xhttp.open("GET", "addfaltabanquillo.php?equipo=" + equipo, true);
        xhttp.send();

    }

/////////////////////////////////////////////////////////////
/*MINUTAJE JUGADORES*/
/////////////////////////////////////////////////////////////

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

    function addtiempoLider(ganador){
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();

        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("La respuesta está completa.");
            }
        };

        // Hacer la solicitud AJAX POST
        xhttp.open("GET", "addtiempoLider.php?ganador=" + ganador, true);
        xhttp.send();
    }

/////////////////////////////////////////////////////////////
/*JUGADORES EN PISTA*/
/////////////////////////////////////////////////////////////

    // Obtener el elemento con la clase "localScore-display"
    let localPlayersDisplay = document.querySelector('.localPlayers-display');
    // Obtener el elemento con la clase "visitScore-display"
    let visitPlayersDisplay = document.querySelector('.visitPlayers-display');

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

        var headers = ['Nº','Ptos.', 'Faltas', 'Time'];

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
            var minutosjugador = Math.floor(jugador.MT / 60);
            var segundosjugador = jugador.MT % 60;
            var minutosPlayer = `${minutosjugador.toString().padStart(2, '0')}:${segundosjugador.toString().padStart(2, '0')}`;

            var playerRow = document.createElement('tr');

            // Crear las celdas para los datos del jugador
            var numberCell = playerRow.insertCell();
            numberCell.innerHTML = jugador.numero;

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
/*SUSTITUCIONES*/
////////////////////////////////////////////////////////////////////////////////////////////

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
        xhttp.open("GET", "getJugadoresSub.php?equipo=" + equipo, true);
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
                mostrarMensajeLogLine("Sustitucion del " + getNombreEquipo(equipo) + " sale el #" + jugadoresSeleccionados[0].numero + " - Por el #" + jugadoresSeleccionados[1].numero);

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

    }

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

//Ventana Emergente que muestra los jugadores en juego, para X equipo, para asignarles X accion

    function missedShot(equipo,jugador,puntos){
        if (puntos < 0) {
            // Acción a realizar si puntos es negativo
            mostrarMensajeLogLine("¡Error! Se elimina el tiro de " + puntos + " fallado del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
        }else{
            mostrarMensajeLogLine("Tiro de " + puntos + " fallado del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));

        }
    }

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
        xhttp.open("GET", "getJugadoresJugando.php?equipo=" + equipo, true);
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

        var h1 = document.createElement("h1");
        h1.textContent = `Equipo: ${equipo}`;
        ventana.appendChild(h1);
        
        var tr = document.createElement("tr");

        for(var j = 0; j < jugadores.length;j++){

            var jugador = jugadores[j];

            var td = document.createElement("td");
            var boton = document.createElement("button");

            boton.textContent = jugador.numero + ' - ' + jugador.nombrejugador;

            boton.addEventListener("click", crearEventoClick(jugador,accion,equipo));

            td.appendChild(boton);
            tr.appendChild(td);

        }

        tabla.appendChild(tr);
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

        // Función para crear el evento click con el valor del jugador como argumento
        function crearEventoClick(jugador,accion,equipo){
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
        xhttp.open("GET", "actualizartablaPartido.php?jugador=" + encodeURIComponent(jugador.numero) + "&accion=" + accion + "&equipo=" + equipo, true);
        xhttp.send();
    }

    function eliminarAccion(jugador,accion, equipo) {
        // Crear una solicitud AJAX
        var xhttp = new XMLHttpRequest();

        // Definir la función de respuesta
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //Actualizar la pantalla
                eliminarAccionPantalla(jugador,accion, equipo);
            }
        };

        // Hacer la solicitud AJAX
        xhttp.open("GET", "removeactualizartablaPartido.php?jugador=" + encodeURIComponent(jugador.numero) + "&accion=" + accion + "&equipo=" + equipo, true);
        xhttp.send();
    }

    function mostrarMensajeLogLine(mensaje) {
        let infoRef = document.querySelector(".info-display");
        let logline = '';
        period = document.getElementById("periodSelect").value;
        logline = `[${period}-Time: ${minutes}:${seconds}-(H:${localpointsElement.textContent} - V:${visitpointsElement.textContent})] - ¡${mensaje}!<br>`;
        infoRef.innerHTML += logline;
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

    function removeactualizarComparativa(campo,equipo){
        if(isLocal(equipo)){
            var parametro = '.' + campo + '-Local';

            let  elemento = document.querySelector(parametro);
            elemento.textContent = parseInt(elemento.textContent) - 1;
        }
        else{
            var parametro = '.' + campo + '-Visitante';


            let  elemento = document.querySelector(parametro);
            elemento.textContent = parseInt(elemento.textContent) - 1;
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

    function removeactualizarTotalTiros(campo,equipo){
        if(isLocal(equipo)){
            let nuevoString = campo.slice(0, campo.length - 1);
            var parametro = '.' + nuevoString + 'T-Local';

            let  elemento = document.querySelector(parametro);
            elemento.textContent = parseInt(elemento.textContent) - 1;
        }
        else{
            let nuevoString = campo.slice(0, campo.length - 1);
            var parametro = '.' + nuevoString + 'T-Visitante';


            let  elemento = document.querySelector(parametro);
            elemento.textContent = parseInt(elemento.textContent) - 1;
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

            elemento.textContent = ((parseFloat(anotados.textContent) / (parseFloat(anotados.textContent) + parseFloat(fallados.textContent))) * 100).toFixed(2);

        }
        else{

            let nuevoString = campo.slice(0, campo.length - 1);

            var parametro = '.' + nuevoString + 'P-Visitante';
            let  elemento = document.querySelector(parametro);

            var anot = '.' + nuevoString + 'A-Visitante';
            let  anotados = document.querySelector(anot);

            var fall = '.' + nuevoString + 'F-Visitante';
            let  fallados = document.querySelector(fall);


            elemento.textContent = ((parseFloat(anotados.textContent) / (parseFloat(anotados.textContent) + parseFloat(fallados.textContent))) * 100).toFixed(2);

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

    function removeactualizarTotalRebotes(equipo){

        if(isLocal(equipo)){
            var parametro = '.RB-Local';

            let  elemento = document.querySelector(parametro);
            elemento.textContent = parseInt(elemento.textContent) - 1;
        }
        else{
            var parametro = ".RB-Visitante";


            let  elemento = document.querySelector(parametro);
            elemento.textContent = parseInt(elemento.textContent) - 1;
        }

    }

    function eliminarAccionPantalla(jugador,accion,equipo){

        //1º Mostrar el Mensaje del LogLine
        // 2º Actualizar Comparativa o Marcador
        switch (accion) {
            case 'T2A':
            // Lógica para actualizar la pantalla cuando se registra un T2A
            addPoints(equipo,jugador,-2);
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'T2F':
            // Lógica para actualizar la pantalla cuando se registra un T2F
            missedShot(equipo,jugador,-2);
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'T3A':
            // Lógica para actualizar la pantalla cuando se registra un T3A
            addPoints(equipo,jugador,-3);
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'T3F':
            // Lógica para actualizar la pantalla cuando se registra un T3F
            missedShot(equipo,jugador,-3);
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'TLA':
            // Lógica para actualizar la pantalla cuando se registra un TLA
            addPoints(equipo,jugador,-1);
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'TLF':
            // Lógica para actualizar la pantalla cuando se registra un TLF
            missedShot(equipo,jugador,-1);
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'FLH':
            // Lógica para actualizar la pantalla cuando se registra una FAL
            mostrarMensajeLogLine("¡Error! Se elimina la falta hecha por el Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            break;
            case 'FLR':
            // Lógica para actualizar la pantalla cuando se registra una FAL
            mostrarMensajeLogLine("Falta recibida por Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            break;
            case 'TEC':
            // Lógica para actualizar la pantalla cuando se registra un TEC
            mostrarMensajeLogLine("¡Error! Se elimina la falta hecha por el Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa('FLH',equipo);
            break;
            case 'RBO':
            // Lógica para actualizar la pantalla cuando se registra un RBO
            mostrarMensajeLogLine("¡Error! Se elimina el Rebote Ofensivo del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalRebotes(equipo);
            break;
            case 'RBD':
            // Lógica para actualizar la pantalla cuando se registra un RBD
            mostrarMensajeLogLine("¡Error! Se elimina el Rebote Defensivo del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            removeactualizarTotalRebotes(equipo);
            break;
            case 'ROB':
            // Lógica para actualizar la pantalla cuando se registra un ROB
            mostrarMensajeLogLine("¡Error! Se elimina el Robo del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            break;
            case 'TAP':
            // Lógica para actualizar la pantalla cuando se registra un TAP
            mostrarMensajeLogLine("¡Error! Se elimina el Tapón del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            break;
            case 'PRD':
            // Lógica para actualizar la pantalla cuando se registra un PRD
            mostrarMensajeLogLine("¡Error! Se elimina la Pérdida del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            break;
            case 'AST':
            // Lógica para actualizar la pantalla cuando se registra un AST
            mostrarMensajeLogLine("¡Error! Se elimina la Asistencia del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            removeactualizarComparativa(accion,equipo);
            break;
            default:
            // Lógica para manejar casos en los que la acción no esté definida
            break;
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
            actualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'T2F':
            // Lógica para actualizar la pantalla cuando se registra un T2F
            missedShot(equipo,jugador,2);
            actualizarComparativa(accion,equipo);
            actualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'T3A':
            // Lógica para actualizar la pantalla cuando se registra un T3A
            addPoints(equipo,jugador,3);
            actualizarComparativa(accion,equipo);
            actualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'T3F':
            // Lógica para actualizar la pantalla cuando se registra un T3F
            missedShot(equipo,jugador,3);
            actualizarComparativa(accion,equipo);
            actualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'TLA':
            // Lógica para actualizar la pantalla cuando se registra un TLA
            addPoints(equipo,jugador,1);
            actualizarComparativa(accion,equipo);
            actualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'TLF':
            // Lógica para actualizar la pantalla cuando se registra un TLF
            missedShot(equipo,jugador,1);
            actualizarComparativa(accion,equipo);
            actualizarTotalTiros(accion,equipo);
            actualizarPorcentaje(accion,equipo);
            break;
            case 'FLH':
            // Lógica para actualizar la pantalla cuando se registra una FAL
            mostrarMensajeLogLine("Falta hecha por el Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            pausarTemporizador();
            actualizarComparativa(accion,equipo);
            break;
            case 'FLR':
            // Lógica para actualizar la pantalla cuando se registra una FAL
            mostrarMensajeLogLine("Falta recibida por Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            break;
            case 'TEC':
            // Lógica para actualizar la pantalla cuando se registra un TEC
            mostrarMensajeLogLine("Falta Técnica del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            pausarTemporizador();
            actualizarComparativa('FLH',equipo);
            break;
            case 'RBO':
            // Lógica para actualizar la pantalla cuando se registra un RBO
            mostrarMensajeLogLine("Rebote Ofensivo del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            actualizarComparativa(accion,equipo);
            actualizarTotalRebotes(equipo);
            break;
            case 'RBD':
            // Lógica para actualizar la pantalla cuando se registra un RBD
            mostrarMensajeLogLine("Rebote Defensivo del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            actualizarComparativa(accion,equipo);
            actualizarTotalRebotes(equipo);
            break;
            case 'ROB':
            // Lógica para actualizar la pantalla cuando se registra un ROB
            mostrarMensajeLogLine("Robo del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            actualizarComparativa(accion,equipo);
            break;
            case 'TAP':
            // Lógica para actualizar la pantalla cuando se registra un TAP
            mostrarMensajeLogLine("Tapón del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            actualizarComparativa(accion,equipo);
            break;
            case 'PRD':
            // Lógica para actualizar la pantalla cuando se registra un PRD
            mostrarMensajeLogLine("Pérdida del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            actualizarComparativa(accion,equipo);
            break;
            case 'AST':
            // Lógica para actualizar la pantalla cuando se registra un AST
            mostrarMensajeLogLine("Asistencia del Nº " + jugador.numero + " de " + getNombreEquipo(equipo));
            actualizarComparativa(accion,equipo);
            break;
            default:
            // Lógica para manejar casos en los que la acción no esté definida
            break;
        }
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
        titulares.textContent = `Selecciona los titulares de ambos equipos:`;
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
        p.textContent = `${local}`;
        contenedorLocal.appendChild(p);
    
        var p = document.createElement("p");
        p.textContent = `${visitante}`;
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
    
    
    }

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

window.addEventListener('beforeunload', function (e) {
    // Cancela el evento de cierre para mostrar el cuadro de diálogo
    e.preventDefault();
    // La mayoría de los navegadores modernos requieren que se le asigne un valor a la propiedad returnValue del evento
    e.returnValue = '';
  
    // Muestra el mensaje de confirmación personalizado
    var confirmationMessage = '¿Estás seguro de que deseas abandonar esta página? Deberías guardar los PDFs';
  
    // Retorna el mensaje de confirmación
    return confirmationMessage;
  });
  