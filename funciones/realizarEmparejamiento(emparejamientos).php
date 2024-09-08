<?php

use function PHPSTORM_META\type;

include_once "../conectarBBDD.php";
$con = conectarBD();

function sacarNombres($con)
{
    
    //  $valoresMarcados = intval($_REQUEST['valoresMarcados']);

    $NombresJuegos = mysqli_query($con,'SELECT idJuego, nombre FROM juegos');
    $resultadoNombreJuegos = mysqli_fetch_all($NombresJuegos);
    $juegos = [];
    $nombreJugadores = [];
    

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



            // sacamos los nombres de los jugadores segun el id que recibimos y los guardamos en un array $nombreJugadores.
            // for ($i=0; $i < count($jugadores) ; $i++) { 

            //     $nomJuga = $con->prepare("SELECT CONCAT(nombre, ' ', apellido1) AS Jugador FROM jugadores WHERE idJugador = ?");
            //     $nomJuga->bind_param("i", $jugadores[$i]);
            //     $nomJuga->execute();
            //     $resultFiltrar = $nomJuga->get_result();
            //     while ($row = $resultFiltrar->fetch_assoc()) {
            //         // $_SESSION['id'] = $row["id_socio"];
            //         array_push($nombreJugadores, $row["Jugador"]);
            //     }  
            // }

            // sacamos el nombre de los jeugos y los guardamos en un array $juegos.
            foreach ($resultadoNombreJuegos as $j) {
                array_push($juegos, $j[1]);
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


    while ($num_jugadores > 0){
        if ($num_jugadores >= 4){
            echo "Hola";
        }
        if ($num_jugadores == 3){
            echo "Hola";
        }
        if ($num_jugadores < 3){
            echo "Hola";
        }
    }




    // ** desde aqui funciona

    // // Contador para juegos
    // $juego_index = 0;

    // // Mientras queden jugadores por organizar
    // while ($num_jugadores > 0) {
    //     if ($num_jugadores % 4 == 0 || $num_jugadores % 4 == 3 ) {
    //         // Si quedan 4 jugadores o el resto es divisible por 4, crear una mesa de 4
    //         $mesa_size = ($num_jugadores >= 4) ? 4 : 3;
    //     } else {
    //         // En otros casos, crear una mesa de 3
    //         $mesa_size = 3;
    //     }
        
    //     // Asignar jugadores a la mesa
    //     $mesa_jugadores = array_splice($nombreJugadores, 0, $mesa_size);
    //     $num_jugadores -= $mesa_size;

    //     // Asignar un juego a la mesa
    //     $mesa_juego = $juegos[$juego_index];
    //     $juego_index++;

    //     // Añadir la mesa con jugadores y su juego asignado
    //     $mesas[] = [
    //         'jugadores' => $mesa_jugadores,
    //         'juego' => $mesa_juego
    //     ];

    //     // Verificar si se acabaron los juegos (opcional, si tienes más jugadores que juegos)
    //     if ($juego_index >= $num_juegos) {
    //         echo "Error: No hay suficientes juegos para asignar a las mesas.\n";
    //         break;
    //     }
    // }

    // // return $mesas;
    // print_r($mesas) ;

    // ** hasta aqui funciona
    mysqli_close($con);
}





sacarNombres($con);