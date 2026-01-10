<?php
include "headerV2.php";
include_once "conectarBBDD.php";
$con = conectarBD();




// selecccionamos el id del jugador que inicia sesion
try {
    $filtrar = $con->prepare(
        "SELECT idJugador  FROM jugadores WHERE nombre = ? AND apellido1 = ?"
    );

    $filtrar->bind_param("ss", $_SESSION["nombre"], $_SESSION["apellido1"]);

    $filtrar->execute();
    $resultFiltrar = $filtrar->get_result();
    $fila = $resultFiltrar->fetch_assoc();
    $idJugador = $fila['idJugador'];
    // echo $idJugador;
    $filtrar->close();





    //     $resumen = $con->prepare("
    //     SELECT 
    //         COUNT(idResultado) AS partidas,
    //         SUM(puntosLiga) + CASE
    //                 WHEN count(r.idJugador) >= 3 AND count(r.idJugador) < 6 THEN 2
    //                 WHEN count(r.idJugador) >= 6 AND count(r.idJugador) < 9 THEN 4
    //                 WHEN count(r.idJugador) >= 9 THEN 6
    //                 ELSE 0
    //             END AS puntosLiga,
    //         SUM(puntosJuego) AS totalJuego,
    //         AVG(puntosLiga) AS mediaLiga,
    //         MAX(puntosLiga) AS mejor,
    //         MIN(puntosLiga) AS peor
    //     FROM resultados
    //     WHERE idJugador = ?
    // ");

    $resumen = $con->prepare("
    SELECT 
        COUNT(idResultado) AS partidas,
        SUM(puntosLiga) AS puntosBaseLiga,

        CASE
            WHEN COUNT(idResultado) >= 3 AND COUNT(idResultado) < 6 THEN 2
            WHEN COUNT(idResultado) >= 6 AND COUNT(idResultado) < 9 THEN 4
            WHEN COUNT(idResultado) >= 9 THEN 6
            ELSE 0
        END AS bonusAsistencia,

        SUM(puntosJuego) AS totalJuego,
        AVG(puntosLiga) AS mediaLiga,
        MAX(puntosLiga) AS mejor,
        MIN(puntosLiga) AS peor
    FROM resultados
    WHERE idJugador = ?
");


    $resumen->bind_param("i", $idJugador);
    $resumen->execute();
    $datosResumen = $resumen->get_result()->fetch_assoc();
    $resumen->close();


    $totalLigaFinal =
        $datosResumen['puntosBaseLiga'] +
        $datosResumen['bonusAsistencia'];

    $totalLiga = $datosResumen['puntosBaseLiga'] + $datosResumen['bonusAsistencia'];



    $historial = $con->prepare("
    SELECT 
        DATE_FORMAT(f.fecha, '%d/%m/%Y') AS fecha,
        j.nombre AS juego,
        r.mesa,
        r.puntosJuego,
        r.puntosLiga
    FROM resultados r
    JOIN juegos j ON r.idJuego = j.idJuego
    JOIN fechasPartidas f ON r.idFecha = f.idfechaPartida
    WHERE r.idJugador = ?
    ORDER BY f.fecha ASC
");

    $historial->bind_param("i", $idJugador);
    $historial->execute();
    $resultHistorial = $historial->get_result();


    //     $grafico = $con->prepare("
    //     SELECT 
    //         f.fecha,
    //         r.puntosLiga
    //     FROM resultados r
    //     JOIN fechasPartidas f ON r.idFecha = f.idfechaPartida
    //     WHERE r.idJugador = ?
    //     ORDER BY f.fecha
    // ");
    $grafico = $con->prepare("
    SELECT 
        f.fecha,
        j.nombre AS juego,
        r.puntosLiga
    FROM resultados r
    JOIN fechasPartidas f ON r.idFecha = f.idfechaPartida
    JOIN juegos j ON r.idJuego = j.idJuego
    WHERE r.idJugador = ?
    ORDER BY f.fecha
");


    $grafico->bind_param("i", $idJugador);
    $grafico->execute();
    $resultGrafico = $grafico->get_result();

    // $fechas = [];
    // $puntos = [];

    // while ($row = $resultGrafico->fetch_assoc()) {
    //     $fechas[] = $row['fecha'];
    //     $puntos[] = $row['puntosLiga'];
    // }
    $labels = [];
    $puntos = [];

    while ($row = $resultGrafico->fetch_assoc()) {
        $labels[] = $row['juego'];
        $puntos[] = $row['puntosLiga'];
    }


    $grafico->close();
} catch (Exception $e) {

    echo "Error : " . $e->getMessage();
}

?>

<div class="container my-5">

    <!-- TÍTULO -->
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">🏆 Mi Liga</h2>
            <p class="text-muted">Resumen personal de tu rendimiento</p>
        </div>
    </div>

    <!-- RESUMEN -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Partidas</h6>
                    <h3><?= $datosResumen['partidas'] ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Puntos totales</h6>
                    <h3><?= $totalLiga ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Puntos Juegos</h6>
                    <h3><?= round($datosResumen['totalJuego'], 2) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-lg">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Mejor</h6>
                    <h3><?= $datosResumen['mejor'] ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-lg">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Peor</h6>
                    <h3><?= $datosResumen['peor'] ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- GRÁFICO -->
    <div class="row mb-5">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    📊 Evolución de puntos
                </div>
                <div class="card-body">
                    <canvas id="graficoPuntos" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- HISTORIAL -->
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    📜 Historial de partidas
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Juego</th>
                                <th>Mesa</th>
                                <th>Puntos Juego</th>
                                <th>Puntos Liga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $resultHistorial->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row['fecha'] ?></td>
                                    <td><?= $row['juego'] ?></td>
                                    <td><?= $row['mesa'] ?></td>
                                    <td><?= $row['puntosJuego'] ?></td>
                                    <td><?= $row['puntosLiga'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>





<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('graficoPuntos');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Puntos de Liga',
                data: <?= json_encode($puntos) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' puntos';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> -->





<!-- <h3>Evolución de puntos (Gráfico de líneas)</h3>
<canvas id="graficoLineas" height="100"></canvas>



<script>
const ctxLineas = document.getElementById('graficoLineas');

new Chart(ctxLineas, {
    type: 'line',  // <--- gráfico de líneas
    data: {
        labels: <?= json_encode($labels) ?>, // nombres de los juegos
        datasets: [{
            label: 'Puntos de Liga',
            data: <?= json_encode($puntos) ?>,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: false,      // no relleno bajo la línea
            tension: 0.3,     // curva suave
            pointRadius: 5,   // tamaño de los puntos
            pointBackgroundColor: 'rgba(54, 162, 235, 1)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.parsed.y + ' puntos';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Puntos de Liga'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Juego'
                },
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45
                }
            }
        }
    }
});
</script> -->





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('graficoPuntos');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Puntos de Liga',
                data: <?= json_encode($puntos) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: false, // no relleno bajo la línea
                tension: 0.3, // curva suave
                pointRadius: 5, // tamaño de los puntos
                pointBackgroundColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' puntos';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        // maxRotation: 45,
                        // minRotation: 45
                        font: {
                            weight: 'bold' // <-- pone los nombres en negrita
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // <-- fuerza solo enteros
                    },
                }
            }
        }
    });
</script>



<?php

$con->close();




include("footer.php");
?>