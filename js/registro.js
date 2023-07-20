
    // Script para controlar la creación de nuevos campos de jugadores
    const agregarJugadorBtn = document.getElementById('agregarJugador');
    const camposJugadoresDiv = document.getElementById('camposJugadores');

    let contadorJugadores = 0;

    agregarJugadorBtn.addEventListener('click', () => {
        contadorJugadores++;

        // Crear los nuevos campos para el jugador
        const nuevoCampo = `
            <fieldset>
                <label for="nombre${contadorJugadores}">Nombre Jugador ${contadorJugadores}:</label>
                <input type="text" id="nombre${contadorJugadores}" name="nombre${contadorJugadores}" required>
                <label for="apellido1${contadorJugadores}">Apellido 1 Jugador ${contadorJugadores}:</label>
                <input type="text" id="apellido1${contadorJugadores}" name="apellido1${contadorJugadores}" required>
                <label for="apellido2${contadorJugadores}">Apellido 2 Jugador ${contadorJugadores}:</label>
                <input type="text" id="apellido2${contadorJugadores}" name="apellido2${contadorJugadores}" required>
            </fieldset>
        `;

        camposJugadoresDiv.innerHTML += nuevoCampo;
    });
