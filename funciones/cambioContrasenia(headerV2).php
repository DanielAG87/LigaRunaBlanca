<?php

include_once "../conectarBBDD.php";


function cambiaContra()
{
    $con = conectarBD();

    $contraActual = intval($_REQUEST['contraActual']);
    $nuevaContra1 = intval($_REQUEST['nuevaContra1']);
    $nuevacontra2 = intval($_REQUEST['nuevacontra2']);
    $correo = intval($_REQUEST['correo']);
    

    $modal = '<div class="modal fade" id="modalCambioContra-22" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title mx-auto" id="exampleModalLabel">Registro</h5>
                            </div>
                            <div class="modal-body mx-auto">
                                <span>';

    $contador = 0;
    $datosFaltantes = "";

    $queEmp_1 = $con->prepare("SELECT contrasenia FROM jugadores WHERE correoElectronico = ?");

    // Verifica si la consulta se preparó correctamente
    if ($queEmp_1 === false) {
        die("Error al preparar la consulta: " . $con->error);
    }

    // Asigna los parámetros a la consulta (el tipo "s" es para strings, ya que tanto correo como contraseña son cadenas)
    $queEmp_1->bind_param("s", $correo);
    // Ejecuta la consulta
    $queEmp_1->execute();
    // Obtiene el resultado de la consulta
    $resEmp_1 = $queEmp_1->get_result();

    
    $fila = $resEmp_1->fetch_assoc();  // fetch_assoc() obtiene una fila como un array asociativo
    $contrasenia = $fila['contrasenia'];  // Aquí se guarda el valor de la contraseña
    

    // controlamos el nombre del jugador
    if (!empty($contraActual)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca la contraseña actual <br />';
    }

    // controlamos el juego
    if (!empty($nuevaContra1) && $contraActual!= $nuevaContra1) {
        $contador++;
    } else {
        $datosFaltantes .= 'La contraseña es igual que la que tienes <br />';
    }
    // controlamos la fecha
    if (!empty($nuevacontra2) && $nuevaContra1 === $nuevacontra2) {
        $contador++;
    } else {
        $datosFaltantes .= 'Las contraseñas nuevas tienen que ser iguales  <br />';
    }
    


    // si todo está correcto hacemos el insert.
    if ($contador == 3) {
        
        

        $anadirResultado = "INSERT INTO resultados (idJugador, idJuego, idFecha, puntosLiga, puntosJuego, mesa) 
                        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_stmt_init($con);

        if (mysqli_stmt_prepare($stmt, $anadirResultado)) {

            if (mysqli_stmt_bind_param($stmt, "iiiiii", $nomJugador, $nomJuego, $fecha, $puntosLiga, $puntosJuego, $mesa)) {

                if (mysqli_stmt_execute($stmt)) {
                    
                    $modal .= '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="green"
                                    class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                </svg> ';
                    $modal .= 'Contraseña cambiada'; 

                } else {
                    $modal .= '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg> ';
                    $modal .= 'Fallo Cambiar la contraseña';
                }
            }
        } else {

            $modal .= '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg> ';
                    $modal .= 'No se ha podido completar la accion, Prueba más tarde';
        }
        mysqli_stmt_close($stmt);
        
       
    }
    else{
        $modal .= '<strong style="color:red;">Faltan datos: </strong><br /> ' . $datosFaltantes;
        
    }

    $modal .= '             </span>
                                </div>
                                <div class="modal-footer mx-auto">
                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>';

    
    mysqli_close($con);
            
    echo $modal;
    
}



cambiaContra(); ?>