<?php

include_once "../conectarBBDD.php";


function addNuevoResultado()
{
    $con = conectarBD();

    $nomJugador = intval($_REQUEST['nomJugador']);
    $nomJuego = intval($_REQUEST['nomJuego']);
    $fecha = intval($_REQUEST['fecha']);
    $puntosLiga = intval($_REQUEST['puntosLiga']);
    $puntosJuego = intval($_REQUEST['puntosJuego']);
    $mesa = intval($_REQUEST['mesa']);
    

    $modal = '<div class="modal fade" id="modalNuevoResultado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title mx-auto" id="exampleModalLabel">Registro</h5>
                            </div>
                            <div class="modal-body mx-auto">
                                <span>';

    $contador = 0;
    $datosFaltantes = "";
    // controlamos el nombre del jugador
    if (!empty($nomJugador) && is_numeric($nomJugador)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca nombre del jugador <br />';
    }

    // controlamos el juego
    if (!empty($nomJuego) && is_numeric($nomJuego)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca juego <br />';
    }
    // controlamos la fecha
    if (!empty($fecha) && is_numeric($fecha)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca fecha  <br />';
    }
    // controlamos los puntos de la liga
    if (!empty($puntosLiga) && $puntosLiga > 0 && is_numeric($puntosLiga)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca los puntos de la liga <br />';
    }
    // controlamos los puntos realizados en el juego 
    if (!empty($puntosJuego) && $puntosJuego >= 0 && is_numeric($puntosJuego)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca los puntos del juego <br />';
    }
    if (!empty($mesa) && is_numeric($mesa)) {
        $contador++;
    } else {
        $datosFaltantes .= 'Introduzca mesa en la que jugó <br />';
    }


    // si todo está correcto hacemos el insert.
    if ($contador == 6) {
        
        

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
                    $modal .= 'Registrado con éxito'; 

                } else {
                    $modal .= '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg> ';
                    $modal .= 'Fallo al registrar resultado';
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

addNuevoResultado(); ?>
