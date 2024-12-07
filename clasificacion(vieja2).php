<?php include "headerV2.php";
include_once "conectarBBDD.php"; 

try {
    $con = conectarBD();

    // Consulta SQL con cálculo directo de puntos adicionales
    $filtrar = $con->prepare('SELECT
            CONCAT(juga.nombre, " ", juga.apellido1) AS nombre_jugador,
            sum(r.puntosLiga) +
            CASE
                WHEN count(r.idJugador) >= 3 AND count(r.idJugador) < 6 THEN 1
                WHEN count(r.idJugador) >= 6 AND count(r.idJugador) < 9 THEN 2
                WHEN count(r.idJugador) >= 9 AND count(r.idJugador) < 10 THEN 3
                WHEN count(r.idJugador) >= 10 THEN 4
                ELSE 0
            END AS puntosLiga,
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
    $devolverClasificacion = mysqli_fetch_all($clasificacion, MYSQLI_ASSOC); // Obtener datos como array asociativo
} catch (Exception $e) {
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
                <th>Posición</th>
                <th>Jugador</th>
                <th>Puntos Liga</th>
                <th>Días Asistencia</th>
                <th>Total Puntos Juegos</th>
            </tr>
            <?php
            $contadorPosicion = 1;
            foreach ($devolverClasificacion as $j) { ?>
                <tr <?php 
                // Resaltar la fila si es "Oriol Torija"
                if ($j['nombre_jugador'] == "Oriol Torija") {
                    echo 'style="border: 2px solid red;"'; 
                } ?>>
                <?php if ($j['nombre_jugador'] == "Oriol Torija") { ?>
                    <!-- Mostrar mensaje adicional solo si es "Oriol Torija" -->
                    <td colspan="5"><strong> ⇧ ⇧ Top Oriol ⇧ ⇧</strong></td>
                </tr>
                <tr>
                    <td><?= $contadorPosicion ?></td>
                    <td><?= $j['nombre_jugador'] ?></td>
                    <td><?= $j['puntosLiga'] ?></td>
                    <td><?= $j['asistencia'] ?></td>
                    <td><?= $j['puntosJuego'] ?></td>
                <?php } else { ?>
                    <td><?= $contadorPosicion ?></td>
                    <td><?= $j['nombre_jugador'] ?></td>
                    <td><?= $j['puntosLiga'] ?></td>
                    <td><?= $j['asistencia'] ?></td>
                    <td><?= $j['puntosJuego'] ?></td>
                <?php } ?>
            </tr>
            <?php  
                $contadorPosicion += 1; 
            } ?>
        </table>
    </div>
</div>
</br>


<?php
include "footer.php";
?>