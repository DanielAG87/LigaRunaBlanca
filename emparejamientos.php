<?php 
include "headerV2.php";
include_once "conectarBBDD.php";
$con = conectarBD();

// Consulta para obtener los emparejamientos (añadimos idMesa)
$query = "
    SELECT e.idJuego, e.idJugador, e.idMesa,
           j.nombre AS nombreJuego,
           CONCAT(p.nombre, ' ', p.apellido1) AS nombreJugador
    FROM emparejamientos e
    JOIN juegos j ON e.idJuego = j.idJuego
    JOIN jugadores p ON e.idJugador = p.idJugador
    ORDER BY e.idMesa, e.idJuego, e.idJugador;
";

$resultado = mysqli_query($con, $query);
if (!$resultado) {
    echo "Error en la consulta: " . mysqli_error($con);
    return;
}

// Agrupar resultados por mesa y juego
$mesas = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $mesas[$fila['idMesa']][$fila['nombreJuego']][] = $fila['nombreJugador'];
}


$jugadorActual = $_SESSION['nombre'] . ' ' . $_SESSION['apellido1'];


// ---- CSS extra para un estilo más claro ----
echo "
<style>
    body { background-color: #f8f9fa; }
    .mesa-card {
        border-left: 8px solid #0d6efd;
        transition: transform 0.15s ease-in-out;
    }
    .mesa-card:hover {
        transform: scale(1.01);
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }
    .mesa-header {
        background: linear-gradient(90deg, #0d6efd, #0a58ca);
        color: white;
    }
    .mesa-juego {
        background-color: #e7f1ff;
        font-weight: bold;
    }
    .mesa-titulo {
        font-weight: 700;
        font-size: 1.2rem;
    }
    .sin-mesa {
        border-left: 8px solid #dc3545;
    }
</style>
";

// ---- Título general ----
echo "<div class='container mt-4'>";
echo "<h2 class='text-center text-primary mb-3'>Emparejamientos</h2>";
echo "<p class='text-center text-muted mb-4'>
        Todas las partidas se jugarán a las <strong>17:00</strong> en el 
        <strong>Espacio para la Creación Joven de Marchamalo</strong>
      </p>";

// ---- Mostrar cada mesa ----
foreach ($mesas as $idMesa => $juegos) {
    echo "<div class='card mesa-card mb-4 shadow-sm'>";
    echo "<div class='card-header mesa-header text-center'>";
    echo "<h4 class='mesa-titulo mb-0'>Mesa {$idMesa}</h4>";
    echo "</div>";

    echo "<div class='card-body bg-white'>";
    echo "<table class='table table-sm table-bordered text-center mb-0'>";
    echo "<thead class='table-light'>";
    echo "<tr><th style='width:25%'>Juego</th><th colspan='4'>Jugadores</th></tr>";
    echo "</thead><tbody>";

    foreach ($juegos as $nombreJuego => $jugadores) {
        echo "<tr>";
        echo "<td class='mesa-juego align-middle'>{$nombreJuego}</td>";
        foreach ($jugadores as $jugador) {
            if($jugadorActual === $jugador){
                echo "<td class='fw-bold text-success'>👉 {$jugador} 👈</td>";
            }
            else{
                echo "<td>{$jugador}</td>";
            }
            
        }
        for ($i = count($jugadores); $i < 4; $i++) {
            echo "<td class='text-muted'>—</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</div>"; // card-body
    echo "</div>"; // card
}
echo "</div>"; // container


// ---- Jugadores sin mesa ----
$query = "
    SELECT CONCAT(j.nombre, ' ', j.apellido1) AS nombreJugador 
    FROM jugadores_sin_mesa js
    JOIN jugadores j ON js.idJugador = j.idJugador
    ORDER BY js.idJugador;
";
$resultado = mysqli_query($con, $query);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    echo "<div class='container mt-5'>";
    echo "<div class='card sin-mesa shadow-sm'>";
    echo "<div class='card-header bg-danger text-white text-center'>";
    echo "<h4 class='mb-0'>Jugadores sin mesa</h4>";
    echo "</div>";
    echo "<div class='card-body bg-white'>";
    echo "<table class='table table-sm table-bordered text-center mb-0'>";
    echo "<thead class='table-light'><tr><th colspan='4'>Jugadores</th></tr></thead><tbody><tr>";

    $contadorCeldas = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        if($jugadorActual === $fila['nombreJugador']){
            echo "<td class='fw-bold text-success'>👉 {$fila['nombreJugador']} 👈</td>";
        }
        else{
             echo "<td>{$fila['nombreJugador']}</td>";
        }
       
        $contadorCeldas++;
        if ($contadorCeldas % 4 === 0) echo "</tr><tr>";
    }

    echo "</tr></tbody></table>";
    echo "</div></div></div>";
}

include("footer.php");
?>
