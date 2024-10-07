<?php include "headerV2.php";
include_once "conectarBBDD.php"; 

try {
    $con = conectarBD();

    // $clasificacion = mysqli_query($con, 
    //     'SELECT 
    //         juga.nombre AS nombre_jugador, 
    //         sum(r.puntosLiga) AS puntosLiga,
    //         sum(r.puntosJuego) AS puntosJuego
    //     FROM resultados r
    //     JOIN jugadores juga ON r.idJugador = juga.idJugador
    //     JOIN juegos juego ON r.idJuego = juego.idJuego
    //     JOIN fechasPartidas fecha ON r.idFecha = fecha.idfechaPartida
    //     GROUP BY nombre_jugador
    //     ORDER BY puntosLiga DESC;');



    $filtrar = $con->prepare('SELECT
                CONCAT(juga.nombre, " ", juga.apellido1) AS  nombre_jugador, 
                sum(r.puntosLiga) AS puntosLiga,
                sum(r.puntosJuego) AS puntosJuego,
                count(r.idJugador) AS asistencia
            FROM resultados r
            JOIN jugadores juga ON r.idJugador = juga.idJugador
            JOIN juegos juego ON r.idJuego = juego.idJuego
            JOIN fechasPartidas fecha ON r.idFecha = fecha.idfechaPartida
            GROUP BY nombre_jugador
            ORDER BY puntosLiga DESC, asistencia DESC, puntosJuego DESC;');
    $filtrar->execute();
    $clasificacion = $filtrar->get_result();
    $devolverClasificacion = mysqli_fetch_all($clasificacion);
    

} 
catch (Exception $e) {
    echo "Error : " . $e->getMessage();
}

mysqli_close($con);




?>
<br>
<br>
<div>
   <h3 class="text-center h3 text-primary vikingo"><u>CLASIFICACIÓN</u></h3>
</div>
<br>


<div class="container-fluid" id="tablaFull">
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered text-center" id="tablaGPT">
            <tr>
                <th>Jugador</td>
                <th>Puntos Liga</td>
                <th>Días Asistencia</td>
                <th>Total Puntos Juegos</td>
            </tr>
            <?php
            foreach ($devolverClasificacion as $j) {?>
                <tr <?php 

                    if ($j[2] >= 3 && $j[2] < 6) {
                        $j[1] += 1; // Sumar 1 punto a $j[1]
                    } elseif ($j[2] >= 6 && $j[2] < 9) {
                        $j[1] += 2; // Sumar 2 puntos a $j[1]
                    } elseif ($j[2] >= 9 && $j[2] < 10) {
                        $j[1] += 3; // Sumar 3 puntos a $j[1]
                    } elseif ($j[2] >= 10) {
                        $j[1] += 4; // Sumar 4 puntos a $j[1]
                    }
                
                
                if ($j[0] == "Oriol Torija") { echo 'style="border: 2px solid red;"'; } ?>>
                <!-- Mostrar mensaje adicional solo si es "Oriol Torija" -->
                <?php if ($j[0] == "Oriol Torija") { ?>
                    <td colspan="4"><strong> ⇧ ⇧ Top Oriol ⇧ ⇧</strong></td> <!-- Mensaje resaltado en una celda completa -->
                </tr>
                <tr >
                    <td><?= $j[0] ?></td>
                    <td><?= $j[1] ?></td>
                    <td><?= $j[3] ?></td>
                    <td><?= $j[2] ?></td>
                <?php } else { ?>
                    <td><?= $j[0] ?></td>
                    <td><?= $j[1] ?></td>
                    <td><?= $j[3] ?></td>
                    <td><?= $j[2] ?></td>
                <?php } ?>
            </tr>


            <?php 
            } ?>

        </table>
    </div>
</div>
</br>





<?php include("footer.php"); ?>