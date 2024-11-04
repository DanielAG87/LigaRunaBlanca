<?php include "headerV2.php";
include_once "conectarBBDD.php";
$con = conectarBD();
// crono
$fecha = mysqli_query(
    $con,
    'SELECT fecha FROM fechasPartidas WHERE fecha > CURDATE()
    ORDER BY ABS(DATEDIFF(fecha, CURDATE())) LIMIT 1;'
);

$resultadofecha = mysqli_fetch_assoc($fecha);
$fechaProxima = $resultadofecha['fecha'];


// convertimos la fecha a lo que requiere el contador de js
$objetoFecha = date_create($fechaProxima);
$fechaModificada = date_format($objetoFecha, 'm/d/Y');
// fin crono



$totalEventos = mysqli_query(
    $con,'SELECT DATE_FORMAT(fecha, "%d-%m-%Y") AS fecha
            FROM fechasPartidas
            ORDER BY YEAR(fecha), MONTH(fecha), DAY(fecha);');



// partidas ya jugadas
$historico = mysqli_query(
    $con,'SELECT 
            CONCAT(juga.nombre, " ", juga.apellido1) AS  Jugador, 
            juego.nombre AS Juego, 
            DATE_FORMAT(fecha.fecha, "%d-%m-%Y") AS Fecha, 
            r.puntosLiga AS "Puntos Liga",
            r.puntosJuego AS "Puntos Juego",
            r.mesa AS Mesa
        FROM resultados r
        JOIN jugadores juga ON r.idJugador = juga.idJugador
        JOIN juegos juego ON r.idJuego = juego.idJuego
        JOIN fechasPartidas fecha ON r.idFecha = fecha.idfechaPartida
        ORDER BY  Fecha, Mesa, r.puntosLiga DESC;');




mysqli_close($con); ?>

<h3 class="text-center h3 text-primary vikingo">Próxima Partida</h3>


<!-- Contador regresivo -->
<div id="bodyCrono" class="mb-3">
    <section class="container" id="sectionCrono">
        <div class="countdown">
            <div>
                <span class="spanCrono"> Día/s</span>
                <p class="pCrono" id="dias"></p>
            </div>
            <div>
                <span class="spanCrono"> Hora/s</span>
                <p class="pCrono" id="horas"></p>
            </div>
            <div>
                <span class="spanCrono"> Minuto/s</span>
                <p class="pCrono" id="minutos"></p>
            </div>
            <div>
                <span class="spanCrono"> Segundo/s</span>
                <p class="pCrono" id="segundos"></p>
            </div>
        </div>
    </section>
</div>
<!-- Fin contador regresivo -->


<div>
    <h3 class="text-center h3 text-primary vikingo">Fechas programadas</h3>
</div>
<br>
<div>
    <h5 class="text-center  vikingo">Todas las partidas se jugarán a las 17:30 en el Espacio para la Creación Joven de Marchamalo</h5>
</div>
<br>



<?php $fechaActual = new DateTime(); ?>


<div class="container-fluid" id="tablaFull">
    <div class="table-responsive" id="tablaGPT">
        <table class="table table-striped table-hover table-bordered text-center" id="tablaPrincipal">
        
            
            <?php
            foreach ($totalEventos as $j) {
                $fechaEvento = DateTime::createFromFormat('d-m-Y', $j['fecha']);
            ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 text-center mb-3"> 
            <tr>
                
                <?php 
                if ($fechaActual > $fechaEvento){ ?>
                    <td style="color: red;">Jugada</td>
                    <td style="color: red;"><?= $j['fecha'] ?></td>
                <?php }
                else{ ?>
                    <td>Pendiente de Jugar</td>
                    <td><?= $j['fecha'] ?></td>
                <?php }?>
            </tr>
            </div>
            
        <?php } ?>
            
        </table>
    </div> </br></br>



    <div>
        <h3 class="text-center h3 text-primary vikingo">Historico de partidas</h3>
    </div>
    </br>

    <div class="container-fluid" id="tablaFull">
        <div class="table-responsive" style="width: 90%;
            margin: 0 auto; 
            padding: 20px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            background-color: #f9f9f9; 
            border-radius: 10px;">
            <table class="table table-striped table-hover table-bordered text-center" id="tablaPrincipal">
                <tr>
                    <th>Jugador</th>
                    <th>Juego</th> 
                    <th>Fecha</th> 
                    <th>Puntos Liga</th> 
                    <th>Puntos Juego</th> 
                    <th>Mesa</th> 
                </tr>
            <?php
            $juegoComodin = "";
            $mesaComodin = "";


            foreach ($historico as $d) { ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 text-center mb-3">  
                <?php  // comprobamos si la mesa y el juego es el mismo, si no es así metemos una separación.
                if(($juegoComodin == $d['Juego'] and $mesaComodin == $d['Mesa']) || ($juegoComodin == "" and  $mesaComodin == "")) { ?>

                    <tr>
                        <td ><?= $d['Jugador'] ?></td>
                        <td><?= $d['Juego'] ?></td>
                        <td ><?= $d['Fecha'] ?></td>
                        <td><?= $d['Puntos Liga'] ?></td>
                        <td ><?= $d['Puntos Juego'] ?></td>
                        <td><?= $d['Mesa'] ?></td>
                    </tr> <?php
                    $juegoComodin = $d['Juego'];
                    $mesaComodin = $d['Mesa']; ?>
                <?php } 
                else{?>
                <tr>
                        <td colspan="6" style="height: 40px;"></td> <!-- Esto añade un hueco en toda la fila -->
                </tr>
                <tr>
                        <td ><?= $d['Jugador'] ?></td>
                        <td><?= $d['Juego'] ?></td>
                        <td ><?= $d['Fecha'] ?></td>
                        <td><?= $d['Puntos Liga'] ?></td>
                        <td ><?= $d['Puntos Juego'] ?></td>
                        <td><?= $d['Mesa'] ?></td>
                    </tr>
                    <?php
                    $juegoComodin = $d['Juego'];
                    $mesaComodin = $d['Mesa']; ?>

                    <?php }
                    ?>
                </tr>
                <?php } ?>
            </div>
    
        </table>
    </div>
</div>

<?php include("footer.php"); ?>




<script>
    var fechaContador = "<?php echo $fechaModificada ?>";

    document.addEventListener('DOMContentLoaded', () => {

        //===
        // VARIABLES
        //===
        const DATE_TARGET = new Date(fechaContador + ' ' + '07:00 PM');
        // DOM 
        const SPAN_dias = document.querySelector('p#dias');
        const SPAN_horas = document.querySelector('p#horas');
        const SPAN_minutos = document.querySelector('p#minutos');
        const SPAN_segundos = document.querySelector('p#segundos');
        // Milisegundos para los calculos
        const MILLIsegundos_OF_A_SECOND = 1000;
        const MILLIsegundos_OF_A_MINUTE = MILLIsegundos_OF_A_SECOND * 60;
        const MILLIsegundos_OF_A_HOUR = MILLIsegundos_OF_A_MINUTE * 60;
        const MILLIsegundos_OF_A_DAY = MILLIsegundos_OF_A_HOUR * 24

        //===
        // FUNCIONES
        //===

        
        function updateCountdown() {
            // Calcular
            const NOW = new Date()
            const DURATION = DATE_TARGET - NOW;
            const REMAINING_dias = Math.floor(DURATION / MILLIsegundos_OF_A_DAY);
            const REMAINING_horas = Math.floor((DURATION % MILLIsegundos_OF_A_DAY) / MILLIsegundos_OF_A_HOUR);
            const REMAINING_minutos = Math.floor((DURATION % MILLIsegundos_OF_A_HOUR) / MILLIsegundos_OF_A_MINUTE);
            const REMAINING_segundos = Math.floor((DURATION % MILLIsegundos_OF_A_MINUTE) / MILLIsegundos_OF_A_SECOND);

            // Render
            SPAN_dias.textContent = REMAINING_dias;
            SPAN_horas.textContent = REMAINING_horas;
            SPAN_minutos.textContent = REMAINING_minutos;
            SPAN_segundos.textContent = REMAINING_segundos;
        }

        //===
        // Iniciar
        //===
        updateCountdown();
        // refrescar cada segundo
        setInterval(updateCountdown, MILLIsegundos_OF_A_SECOND);
    });
</script>

