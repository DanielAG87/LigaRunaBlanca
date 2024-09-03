<?php

include_once "../conectarBBDD.php";


function emparejamientos()
{
    $con = conectarBD();

    //  $valoresMarcados = intval($_REQUEST['valoresMarcados']);

    $NombresJuegos = mysqli_query($con,'SELECT nombre FROM juegos');
    $resultadoNombreJuegos = mysqli_fetch_assoc($NombresJuegos);
    
    mysqli_close($con);


    // echo $valoresMarcados;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener el contenido del cuerpo de la solicitud
        $data = file_get_contents('php://input');
    
        // Decodificar el JSON en un array asociativo
        $jsonDatos = json_decode($data, true);
    
        if (json_last_error() === JSON_ERROR_NONE) {
            // Extraer el array de valores marcados
            $valoresMarcados = $jsonDatos['valoresMarcados'];
    
            // Aquí puedes trabajar con el array de valores marcados
            // Por ejemplo, imprimirlo para verificar
            echo 'IDs recibidos: ' . implode(', ', $valoresMarcados);
        } else {
            echo 'Error al decodificar JSON: ' . json_last_error_msg();
        }
    } else {
        echo 'Solicitud no válida';
    }
    



}

emparejamientos();