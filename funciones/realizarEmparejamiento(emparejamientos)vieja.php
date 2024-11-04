<?php

// use function PHPSTORM_META\type;

include_once "../conectarBBDD.php";
$con = conectarBD();

function sacarNombres($con)
{
    
    //  $valoresMarcados = intval($_REQUEST['valoresMarcados']);

    $NombresJuegos = mysqli_query($con,'SELECT idJuego, nombre FROM juegos');
    $resultadoNombreJuegos = mysqli_fetch_all($NombresJuegos);
    $juegos = [];
    $nombreJugadores = [];
    
    $consultaPartidas = mysqli_query($con,'SELECT idJugador, idJuego FROM resultados');




    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener el contenido del cuerpo de la solicitud
        $data = file_get_contents('php://input');
    
        // Decodificar el JSON en un array asociativo
        $jsonDatos = json_decode($data, true);
    
        if (json_last_error() === JSON_ERROR_NONE) {
            // Extraer el array de valores marcados
            $valoresMarcados = $jsonDatos['valoresMarcados'];

            // array de jugadores con su id
            $jugadores = array_map('intval', $valoresMarcados);



        

            // sacamos el nombre de los juegos y los guardamos en un array $juegos.
            foreach ($resultadoNombreJuegos as $j) {
                array_push($juegos, $j[0]);
            }


















            // emparejamientos($juegos, $nombreJugadores);
            emparejamientos($con, $juegos, $jugadores);

        } else {
            echo 'Error al decodificar JSON: ' . json_last_error_msg();
        }
    } else {
        echo 'Solicitud no válida';
    } 
}


function emparejamientos($con, $juegos, $jugadores){

   
 // TODO**********************


    shuffle($jugadores); // Mezclar jugadores aleatoriamente
    shuffle($juegos); // Mezclar juegos aleatoriamente
    $num_jugadores = count($jugadores);
    $num_juegos = count($juegos);
    $mesas = [];






    
    print_r($mesas) ;

    // ** hasta aqui funciona
    mysqli_close($con);
}





sacarNombres($con);