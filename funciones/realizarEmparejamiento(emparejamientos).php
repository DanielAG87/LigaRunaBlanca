<?php

include_once "../conectarBBDD.php";
$con = conectarBD();


$query = "DELETE FROM emparejamientos";
$query2 = "DELETE FROM jugadores_sin_mesa";

if (mysqli_query($con, $query) && mysqli_query($con, $query2)) {
    echo "Todos los datos han sido eliminados de la tabla emparejamientos y jugadores sin mesa.";
} else {
    echo "Error al eliminar los datos: " . mysqli_error($con);
}


function sacarNombres($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = file_get_contents('php://input');
        $jsonDatos = json_decode($data, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $valoresMarcados = $jsonDatos['valoresMarcados'];
            $jugadores = array_map('intval', $valoresMarcados);

            // Obtener nombres de los jugadores
            $consultaNombresJugadores = mysqli_query($con, 'SELECT idJugador, CONCAT(nombre, " ", apellido1) AS  nombre_jugador FROM jugadores');
            $nombreJugadores = [];
            while ($row = mysqli_fetch_assoc($consultaNombresJugadores)) {
                $nombreJugadores[intval($row['idJugador'])] = $row['nombre_jugador'];
            }

            // Obtener nombres de los juegos
            $consultaNombresJuegos = mysqli_query($con, 'SELECT idJuego, nombre FROM juegos');
            $nombreJuegos = [];
            $juegos = [];
            while ($row = mysqli_fetch_assoc($consultaNombresJuegos)) {
                $nombreJuegos[intval($row['idJuego'])] = $row['nombre'];
                $juegos[] = intval($row['idJuego']);  // Array de IDs de juegos
            }

            // Obtener los juegos jugados por cada jugador
            $consultaPartidas = mysqli_query($con, 'SELECT idJugador, GROUP_CONCAT(idJuego ORDER BY idJuego ASC) AS juegos FROM resultados GROUP BY idJugador');
            $resultadojuegosJugados = mysqli_fetch_all($consultaPartidas);

            // Llamar a la función emparejamientos con los nombres mapeados
            emparejamientos($con, $juegos, $jugadores, $resultadojuegosJugados, $nombreJugadores, $nombreJuegos);
        } else {
            echo 'Error al decodificar JSON: ' . json_last_error_msg();
        }
    } else {
        echo 'Solicitud no válida';
    }
}










function emparejamientos($con, $juegos, $jugadores, $resultadojuegosJugados, $nombreJugadores, $nombreJuegos) {
    shuffle($jugadores);
    shuffle($juegos);

    $juegosJugadosPorJugador = [];
    foreach ($resultadojuegosJugados as $resultado) {
        $idJugador = intval($resultado[0]);
        $juegosJugados = explode(",", $resultado[1]);
        $juegosJugadosPorJugador[$idJugador] = array_map('intval', $juegosJugados);
    }

    $mesas = [];
    $jugadoresSinMesa = [];

    foreach ($juegos as $indexJuego => $juego) {
        $mesa = [];
        
        foreach ($jugadores as $indexJugador => $jugador) {
            // Solo agregar jugadores que no han jugado este juego
            if (!isset($juegosJugadosPorJugador[$jugador]) || !in_array($juego, $juegosJugadosPorJugador[$jugador])) {
                $mesa[] = $jugador; // Agregar jugador a la mesa
                unset($jugadores[$indexJugador]); // Eliminar jugador de la lista

                // Si la mesa tiene 4 jugadores, se puede cerrar
                if (count($mesa) === 4) {
                    break;
                }
            }
        }

        // Si la mesa tiene al menos 3 jugadores, guardamos el emparejamiento
        if (count($mesa) >= 3) {
            $mesas[] = [
                "juego" => $nombreJuegos[$juego],
                "jugadores" => array_map(function($id) use ($nombreJugadores) {
                    return $nombreJugadores[$id];
                }, $mesa)
            ];
            unset($juegos[$indexJuego]); // Eliminar el juego que se ha utilizado
        } else {
            // Si no se forman mesas, volver a agregar los jugadores no usados
            // $jugadores = array_merge($jugadores, $mesa);
            $jugadoresSinMesa = array_merge($jugadoresSinMesa, $mesa);
        }
    }



        // guardarlo en la base de datos
    foreach ($mesas as $mesa) {
        // Guardar en la base de datos
        $idJuego = array_search($mesa['juego'], $nombreJuegos); // Obtener el ID del juego
        foreach ($mesa['jugadores'] as $jugadorNombre) {
            // Obtener el ID del jugador
            $idJugador = array_search($jugadorNombre, $nombreJugadores);

            // Insertar en la tabla emparejamientos
            $queryInsert = "INSERT INTO emparejamientos (idJuego, idJugador) VALUES ($idJuego, $idJugador)";
            mysqli_query($con, $queryInsert);
        }
    }


    // Guardar jugadores sin mesa en la base de datos
    foreach ($jugadoresSinMesa as $idJugador) {
        $queryInsertSinMesa = "INSERT INTO jugadores_sin_mesa (idJugador) VALUES ($idJugador)";
        mysqli_query($con, $queryInsertSinMesa);
    }


    // // Mostrar las mesas en una tabla HTML con Bootstrap
    // echo "<h2 class='mt-4 text-center'>Mesas organizadas</h2>";
    // echo "<table class='table table-striped table-bordered mx-auto' style='max-width: 800px;'>";
    // echo "<thead class='thead-dark'><tr><th>Juego</th><th>Jugadores</th></tr></thead>";
    // echo "<tbody>";
    // foreach ($mesas as $mesa) {
    //     echo "<tr>";
    //     echo "<td>{$mesa['juego']}</td>";
    //     echo "<td>" . implode(", ", $mesa['jugadores']) . "</td>";
    //     echo "</tr>";
    // }
    // echo "</tbody>";
    // echo "</table>";

    // // Mostrar jugadores sin mesa en una lista con Bootstrap
    // if (!empty($jugadores)) {
    //     echo "<h2 class='mt-4 text-center'>Jugadores sin mesa</h2>";
    //     echo "<ul class='list-group mx-auto' style='max-width: 400px;'>";
    //     foreach ($jugadores as $id) {
    //         echo "<li class='list-group-item'>{$nombreJugadores[$id]}</li>";
    //     }
    //     echo "</ul>";
    // }
}






















sacarNombres($con);