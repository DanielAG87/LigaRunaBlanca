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
                juga.nombre AS nombre_jugador, 
                sum(r.puntosLiga) AS puntosLiga,
                sum(r.puntosJuego) AS puntosJuego
            FROM resultados r
            JOIN jugadores juga ON r.idJugador = juga.idJugador
            JOIN juegos juego ON r.idJuego = juego.idJuego
            JOIN fechasPartidas fecha ON r.idFecha = fecha.idfechaPartida
            GROUP BY nombre_jugador
            ORDER BY puntosLiga DESC;');
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
            <table class="table table-striped table-hover table-bordered text-center" style="width: 80%; margin:auto">
                <tr>
                    <th>Jugador</td>
                    <th>Puntos Liga</td>
                    <th>Total Puntos Juegos</td>
                </tr>
                <?php
                foreach ($devolverClasificacion as $j) {?>
                    <tr>
                        <td><?= $j[0] ?></td>
                        <td><?= $j[1] ?></td>
                        <td><?= $j[2] ?></td>
                    </tr>
    
                <?php 
                } ?>
    
            </table>
        </div>
    </div>





<?php include("footer.php"); ?>