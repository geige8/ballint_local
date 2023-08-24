<?php
namespace es\ucm\fdi;

class Entrenador{

    protected $id;

    public function __construct($id){ //OK
        $this->id = $id;
    }

    
    public static function getEntrenadoresEquipo($equipo_id){

        $id_equipo = Equipo::getidEquipo($equipo_id);

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("
        SELECT entrenadores.id AS jugador_id, user, nombre, apellido1, apellido2
        FROM entrenadores 
        WHERE entrenadores.user IN (
            SELECT user FROM credenciales WHERE id IN (
                SELECT usuario_id FROM usuarios_equipos WHERE equipo_id = '%s'
            )
            )
        ", $id_equipo);
    

        $rs = $conn->query($query);

        $result = false;
        $entrenadores = array();
            if ($rs) {
                $i = 0;
                while ($row = $rs->fetch_assoc()) {
                    $entrenadores[$i] = array(
                        'user' => $row['user'],
                        'nombre' => $row['nombre'],
                        'apellido1' => $row['apellido1'],
                        'apellido2' => $row['apellido2'],
                    );
                    $i++;
                }
                $result = $entrenadores;
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        return $result;
    }

}
