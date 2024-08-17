<?php include "headerV2.php";
include_once "conectarBBDD.php";
$con = conectarBD();
// crono
$fecha = mysqli_query(
    $con,
    'SELECT fecha FROM fechaspartidas WHERE fecha > CURDATE()
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
            ORDER BY MONTH(fecha), DAY(fecha);');


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
    <h5 class="text-center  vikingo">Todas las partidas se jugarán a las 17:30 en el centro juvenil de Marchamalo</h5>
</div>
<br>



<?php $fechaActual = new DateTime(); ?>


<div class="container-fluid" id="tablaFull">
    <div class="table-responsive">
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
    </div>


<?php include("footer.php"); ?>






<script>
    var fechaContador = "<?php echo $fechaModificada ?>";

    document.addEventListener('DOMContentLoaded', () => {

        //===
        // VARIABLES
        //===
        const DATE_TARGET = new Date(fechaContador + ' ' + '10:00 AM');
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

