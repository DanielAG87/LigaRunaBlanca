<?php include "headerV2.php";
include_once "conectarBBDD.php";
$con = conectarBD();

// sacamos los nombres de todos los jugadores
$NombresJugadores = mysqli_query($con,'SELECT idJugador, CONCAT(nombre, " ", apellido1) AS  "Nombre Jugador" FROM jugadores');
$resultadoNombreJugadores = mysqli_fetch_all($NombresJugadores);

mysqli_close($con);


$contadorJugadores = 0;
?>

<div class="container">
    <div id="tablaGPT">
        
        <?php 
        foreach ($resultadoNombreJugadores as $j) {?>
            <label for="checkbox<?=$contadorJugadores?>">
                <input type="checkbox" id="checkbox<?=$contadorJugadores?>" name="option1" value="<?= $j[0] ?>">  <?= $j[1] ?>
            </label><br>
        <?php
            $contadorJugadores++;
        } ?> </br>
        <button type="button" id="" class="btn btn-outline-primary m-2 " onclick="verificarCheckBox()">Generar Nuevas Mesas</button>
    </div>
</div>



<div id="emparejamientos"></div>


<?php include("footer.php"); ?>

<script>
    function verificarCheckBox(){
        const checkboxes = document.querySelectorAll('#tablaGPT input[type="checkbox"]');
        // Obtener la cantidad total de checkboxes
        const totalCheckboxes = checkboxes.length;
        //console.log("Cantidad total de checkboxes:", totalCheckboxes);

        let valoresMarcados = [];

        // Iterar sobre cada checkbox para verificar si está marcado, los marcados guardamos el id del jugador en un array.
        for (let i = 0; i < totalCheckboxes; i++) {
            if (checkboxes[i].checked) {
                // console.log("Checkbox " + (i + 1) + " está marcado.");
                valoresMarcados.push(checkboxes[i].value);
            } 
        }
        console.log("Valores marcados:", valoresMarcados);


        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // falta printarlo
                console.log('Respuesta del servidor:', this.responseText);
                document.getElementById('emparejamientos').innerHTML = this.responseText;
            }
        };

        // xhttp.open("POST", "funciones/realizarEmparejamiento(emparejamientos).php?valoresMarcados=" + valoresMarcados, true);

        // xhttp.send();
        xhttp.open("POST", "funciones/realizarEmparejamiento(emparejamientos).php", true);
        xhttp.setRequestHeader("Content-Type", "application/json");

        // Convertir el array a JSON y enviarlo en el cuerpo de la solicitud
        xhttp.send(JSON.stringify({ valoresMarcados: valoresMarcados }));
    }

    
</script>