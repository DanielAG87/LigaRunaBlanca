<?php include "headerV2.php";
include_once "conectarBBDD.php"; 

$fechaHoy = new DateTime();



$con = conectarBD();

try {
    $gente = $con->prepare('SELECT idJugador, nombre, apellido1 FROM  jugadores;');
    $gente->execute();
    $Jugadores = $gente->get_result();
    $devolverJugadores = mysqli_fetch_all($Jugadores);


    $juegos = $con->prepare('SELECT idJuego, nombre FROM  juegos;');
    $juegos->execute();
    $JJuego = $juegos->get_result();
    $devolverJuegos = mysqli_fetch_all($JJuego);


    $fecha = $con->prepare('SELECT idfechaPartida, DATE_FORMAT(fecha, "%d-%m-%Y") AS fecha FROM  fechasPartidas ORDER BY YEAR(fecha), MONTH(fecha), DAY(fecha) ;');
    $fecha->execute();
    $FFecha = $fecha->get_result();
    $devolverFechas = mysqli_fetch_all($FFecha);
} 
catch (Exception $e) {
    echo "Error : " . $e->getMessage();
}

 ?>


<div class="container">
    <div id="tablaGPT">
        <fieldset>
            <legend style="text-align: center;">Registrar resultados</legend>

            <select class="form-select " id="nomJugador">
                <option disabled selected>Nombre Jugador</option>
                <?php
                foreach ($devolverJugadores as $j) { ?>
                    <option value="<?= $j[0] ?>"><?= $j[1] . " " . $j[2] ?></option>
                <?php  
                }
                ?>
            </select> </br>

            <select class="form-select " id="nomJuego">
                <option disabled selected>Juego</option>
                <?php
                foreach ($devolverJuegos as $d) { ?>
                    
                    
                        <option value="<?= $d[0] ?>"><?= $d[1] ?></option> 

                <?php 
                } ?>
            </select></br>

            <select class="form-select " id="fecha">
                <option disabled selected>Fecha</option>
                <?php
                foreach ($devolverFechas as $f) { 
                    
                    $fechaIngresada = new DateTime($f[1]);
                    $fechaLimite = clone $fechaHoy;
                    $fechaLimite->modify('-1 day');
                    if ($fechaIngresada < $fechaLimite) { ?>
                        <option style="color: red;" value="<?= $f[0] ?>"><?= $f[1] ?></option>  <?php
                    }
                    else{ ?>
                        <option value="<?= $f[0] ?>"><?= $f[1] ?></option> <?php
                    } 
                }?>
            </select></br>
    
            <select class="form-select " id="puntosLiga">
                <option disabled selected>Puntos Liga (Mesas4 jugadores)</option>
                <option>8</option>
                <option>5</option>
                <option>3</option>
                <option>1</option>
                <option disabled>Mesas 3 jugadores</option>
                <option>6</option>
                <option>4</option>
                <option>2</option>
            </select></br>

            <input type="number" id="puntosJuego" class="form-control" placeholder="Puntos en el juego" /></br>
            <input type="number" id="mesa" class="form-control" placeholder="Mesa" />

            <br />
            <div class="d-flex justify-content-center">
                <button type="submit" id="limpiar" class="btn btn-outline-danger m-2">Limpiar campos</button>
                <button type="button" id="" class="btn btn-outline-success m-2 " onclick="actualizarResultados()">Actualizar</button>
            </div> 
        </fieldset>
    </div>
</div>


<?php 


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



<script>
    $(document).ready(function() {
        // codigo para limpiar los campos del formulario
        $(document).ready(function() {
            $("#limpiar").click(function() {
                $("#mesa, #puntosJuego").val("");
                $("#nomJugador").prop("selectedIndex", 0);
                $("#nomJuego").prop("selectedIndex", 0);
                $("#fecha").prop("selectedIndex", 0);
                $("#puntosLiga").prop("selectedIndex", 0);
            });
        });
    });




    function actualizarResultados() {

        var nomJugador = document.getElementById("nomJugador").value;
        var nomJuego = document.getElementById("nomJuego").value;
        var fecha = document.getElementById("fecha").value;
        var puntosLiga = document.getElementById("puntosLiga").value;
        var puntosJuego = document.getElementById("puntosJuego").value;
        var mesa = document.getElementById("mesa").value;
        

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // $(document).ready(function() {
                //     $("#modalNuevoResultado").modal("show");
                // });
                document.body.insertAdjacentHTML('beforeend', this.responseText);
                // Muestra el modal
                var modal = new bootstrap.Modal(document.getElementById('modalNuevoResultado'));
                modal.show();

                $(document).ready(function() {
                // codigo para limpiar los campos del formulario
                    $(document).ready(function() {
                        $("#mesa, #puntosJuego").val("");
                        $("#nomJugador").prop("selectedIndex", 0);
                        $("#nomJuego").prop("selectedIndex", 0);
                        $("#fecha").prop("selectedIndex", 0);
                        $("#puntosLiga").prop("selectedIndex", 0);
                    });
                });  
            }
        };
        xhttp.open("POST", "funciones/actualizarResultado(gestion).php?nomJugador=" + nomJugador + "&nomJuego=" + nomJuego + "&fecha=" + fecha + "&puntosLiga=" +
            puntosLiga + "&puntosJuego=" + puntosJuego + "&mesa=" + mesa, true);
        xhttp.send();
    }

</script>