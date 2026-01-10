<?php include "headerV2.php";
include_once "conectarBBDD.php";

try {
    $con = conectarBD();

    // Consulta SQL con cálculo directo de puntos adicionales
    $filtrar = $con->prepare('SELECT
            CONCAT(juga.nombre, " ", juga.apellido1) AS nombre_jugador,
            sum(r.puntosLiga) +
            CASE
                WHEN count(r.idJugador) >= 3 AND count(r.idJugador) < 6 THEN 2
                WHEN count(r.idJugador) >= 6 AND count(r.idJugador) < 9 THEN 4
                WHEN count(r.idJugador) >= 9 THEN 6
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


$jugadorActual = $_SESSION['nombre'] . ' ' . $_SESSION['apellido1'];

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
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Jugador</th>
                    <th>Puntos Liga</th>
                    <th>Días Asistencia</th>
                    <th>Total Puntos Juegos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $contadorPosicion = 1;
                foreach ($devolverClasificacion as $j) {
                    // Determinar el color de la celda según la posición
                    $colorPosicion = '';
                    if ($contadorPosicion == 1) {
                        $colorPosicion = 'background-color: gold;';  // Oro
                    } elseif ($contadorPosicion == 2) {
                        $colorPosicion = 'background-color: silver;';  // Plata
                    } elseif ($contadorPosicion == 3) {
                        $colorPosicion = 'background-color: #cd7f32;';  // Bronce
                    }
                ?>
                    <?php if ($j['nombre_jugador'] == "Oriol Torija") { ?>
                        <!-- Fila resaltada con mensaje adicional para "Oriol Torija" -->
                        <tr style="border: 2px solid red;">
                            <td colspan="5"><strong> ⇧ ⇧ Top Oriol ⇧ ⇧</strong></td> <!-- Ahora ocupa las 5 columnas -->
                        </tr>



                    <?php }
                    if ($j['nombre_jugador'] === $jugadorActual) { ?>
                        <tr>
                            <td class="fw-bold" style="<?= $colorPosicion ?>">👉  <?= $contadorPosicion ?> 👈</td> <!-- Color según la posición -->
                            <td class="fw-bold"><?= $j['nombre_jugador'] ?></td>
                            <td class="fw-bold"><?= $j['puntosLiga'] ?></td>
                            <td class="fw-bold"><?= $j['asistencia'] ?></td>
                            <td class="fw-bold"><?= $j['puntosJuego'] ?></td>
                        </tr>
                    <?php
                    } else { ?>
                        <!-- Fila normal para otros jugadores -->
                        <tr>
                            <td style="<?= $colorPosicion ?>"><?= $contadorPosicion ?></td> <!-- Color según la posición -->
                            <td><?= $j['nombre_jugador'] ?></td>
                            <td><?= $j['puntosLiga'] ?></td>
                            <td><?= $j['asistencia'] ?></td>
                            <td><?= $j['puntosJuego'] ?></td>
                        </tr>
                    <?php } ?>
                <?php
                    $contadorPosicion += 1;
                } ?>
            </tbody>
        </table>
    </div>
</div>




<?php
include "footer.php";
?>