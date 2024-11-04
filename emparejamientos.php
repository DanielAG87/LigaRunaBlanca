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

// Mostrar las mesas en una tabla HTML con Bootstrap
echo "<h2 class='mt-4 text-center'>Emparejamientos</h2>";
echo "<table class='table table-striped table-bordered mx-auto' style='max-width: 800px;'>";
echo "<thead class='thead-dark'><tr><th class='text-center'>Juego</th><th class='text-center'>Jugadores</th></tr></thead>";
echo "<tbody>";
foreach ($mesas as $juego => $jugadores) {
    echo "<tr>";
    echo "<td class='text-center'>{$juego}</td>";
    echo "<td class='text-center'>" . implode(" --- ", $jugadores) . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";






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

// Mostrar los jugadores sin mesa en una tabla HTML con Bootstrap
echo "<h2 class='mt-4 text-center'>Jugadores sin mesa</h2>";
echo "<table class='table table-striped table-bordered mx-auto' style='max-width: 400px;'>";
echo "<thead class='thead-dark'><tr><th class='text-center'>Nombre</th></tr></thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {
 echo "<tr>";
 echo "<td class='text-center'>{$fila['nombreJugador']}</td>";
 echo "</tr>";
}

echo "</tbody>";
echo "</table>";

 include("footer.php"); ?>

