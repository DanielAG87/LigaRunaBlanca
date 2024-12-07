<?php include "headerV2.php";
include_once "conectarBBDD.php";
$con = conectarBD();


// Consulta para obtener los emparejamientos
$query = "
    SELECT e.idJuego, e.idJugador, j.nombre AS nombreJuego, CONCAT(p.nombre, ' ', p.apellido1) AS nombreJugador      
    FROM emparejamientos e
    JOIN juegos j ON e.idJuego = j.idJuego
    JOIN jugadores p ON e.idJugador = p.idJugador
    ORDER BY e.idJuego, e.idJugador;
";

$resultado = mysqli_query($con, $query);

if (!$resultado) {
    echo "Error en la consulta: " . mysqli_error($con);
    return;
}

// Agrupar los resultados por juego
$mesas = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $mesas[$fila['nombreJuego']][] = $fila['nombreJugador'];
}

// // Mostrar las mesas en una tabla HTML con Bootstrap
// echo "<h2 class='mt-4 text-center'>Emparejamientos</h2>";
// echo "<table class='table table-striped table-bordered mx-auto' style='max-width: 800px;'>";
// echo "<thead class='thead-dark'><tr><th class='text-center'>Juego</th><th class='text-center'>Jugadores</th></tr></thead>";
// echo "<tbody>";
// foreach ($mesas as $juego => $jugadores) {
//     echo "<tr>";
//     echo "<td class='text-center'>{$juego}</td>";
//     echo "<td class='text-center'>" . implode(" --- ", $jugadores) . "</td>";
//     echo "</tr>";
// }
// echo "</tbody>";
// echo "</table>";









// // Mostrar las mesas en una tabla HTML con Bootstrap
// echo "<div class='container mt-4'>";
// echo "<h2 class='text-center text-primary mb-4'>Emparejamientos</h2>";
// echo "<div class='table-responsive'>";
// echo "<table class='table table-hover table-bordered mx-auto text-center' style='max-width: 900px;'>";
// echo "<thead class='thead-light'>";
// echo "<tr class='table-primary'>";
// echo "<th class='align-middle' style='width: 40%;'>Juego</th>";
// echo "<th class='align-middle' style='width: 60%;'>Jugadores</th>";
// echo "</tr>";
// echo "</thead>";
// echo "<tbody>";

// foreach ($mesas as $juego => $jugadores) {
//     echo "<tr>";
//     echo "<td class='align-middle font-weight-bold' style='background-color: #f9f9f9;'>{$juego}</td>";
//     echo "<td class='align-middle' style='background-color: #fefefe;'>" . implode(" <span class='text-primary'>•</span> ", $jugadores) . "</td>";
//     echo "</tr>";
// }

// echo "</tbody>";
// echo "</table>";
// echo "</div>";
// echo "</div>";


// Mostrar las mesas en una tabla HTML con Bootstrap
echo "<div class='container mt-4'>";
echo "<h2 class='text-center text-primary mb-4'>Emparejamientos</h2>";
echo "<div>";
echo "<h5 class='text-center  vikingo'>Todas las partidas se jugarán a las 17:30 en el Espacio para la Creación Joven de Marchamalo</h5>";
echo "</div>";
echo "<br>";
echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered mx-auto text-center' style='max-width: 900px;'>";
echo "<thead class='thead-light'>";
echo "<tr class='table-primary'>";
echo "<th class='align-middle' style='width: 40%;'>Juego</th>";
echo "<th class='align-middle' colspan='4' style='width: 60%;'>Jugadores</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($mesas as $juego => $jugadores) {
    echo "<tr>";
    // Columna del juego
    echo "<td class='align-middle font-weight-bold' style='background-color: #f9f9f9;'>{$juego}</td>";
    
    // Celdas para jugadores
    foreach ($jugadores as $jugador) {
        echo "<td class='align-middle' style='background-color: #fefefe;'>{$jugador}</td>";
    }
    
    // Agregar celdas vacías si hay menos de 4 jugadores
    for ($i = count($jugadores); $i < 4; $i++) {
        echo "<td class='align-middle' style='background-color: #fefefe;'>-</td>";
    }
    
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";






 // Consulta para obtener los jugadores sin mesa
 $query = "
 SELECT  CONCAT(j.nombre, ' ', j.apellido1) AS nombreJugador 
 FROM jugadores_sin_mesa js
 JOIN jugadores j ON js.idJugador = j.idJugador
 ORDER BY js.idJugador;
";

$resultado = mysqli_query($con, $query);

if (!$resultado) {
 echo "Error en la consulta: " . mysqli_error($con);
 return;
}

// // Mostrar los jugadores sin mesa en una tabla HTML con Bootstrap
// echo "<h2 class='mt-4 text-center'>Jugadores sin mesa</h2>";
// echo "<table class='table table-striped table-bordered mx-auto' style='max-width: 400px;'>";
// echo "<thead class='thead-dark'><tr><th class='text-center'>Nombre</th></tr></thead>";
// echo "<tbody>";

// while ($fila = mysqli_fetch_assoc($resultado)) {
//  echo "<tr>";
//  echo "<td class='text-center'>{$fila['nombreJugador']}</td>";
//  echo "</tr>";
// }

// echo "</tbody>";
// echo "</table>";







// // Mostrar los jugadores sin mesa en una tabla HTML con Bootstrap
// echo "<div class='container mt-4'>";
// echo "<h2 class='text-center text-danger mb-4'>Jugadores sin mesa</h2>";
// echo "<div class='table-responsive'>";
// echo "<table class='table table-hover table-bordered mx-auto text-center' style='max-width: 500px;'>";
// echo "<thead class='thead-light'>";
// echo "<tr class='table-danger'>";
// echo "<th class='align-middle'>Nombre</th>";
// echo "</tr>";
// echo "</thead>";
// echo "<tbody>";

// while ($fila = mysqli_fetch_assoc($resultado)) {
//     echo "<tr>";
//     echo "<td class='align-middle' style='background-color: #fefefe;'>{$fila['nombreJugador']}</td>";
//     echo "</tr>";
// }

// echo "</tbody>";
// echo "</table>";
// echo "</div>";
// echo "</div>";





// Mostrar los jugadores sin mesa en una tabla HTML con Bootstrap
echo "<div class='container mt-4'>";
echo "<h2 class='text-center text-danger mb-4'>Jugadores sin mesa</h2>";
echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered mx-auto text-center' style='max-width: 600px;'>";
echo "<thead class='thead-light'>";
echo "<tr class='table-danger'>";
echo "<th class='align-middle' colspan='4'>Jugadores</th>"; // Ajustar a 4 columnas
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Crear un contador para controlar las filas y celdas
$contadorCeldas = 0;
echo "<tr>"; // Inicia la primera fila

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<td class='align-middle' style='background-color: #fefefe;'>{$fila['nombreJugador']}</td>";
    $contadorCeldas++;

    // Si llegamos a 4 celdas, cerramos la fila y abrimos una nueva
    if ($contadorCeldas % 4 === 0) {
        echo "</tr><tr>";
    }
}

// Cierra la última fila abierta, incluso si tiene menos de 4 celdas
echo "</tr>";

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";


include("footer.php"); ?>

