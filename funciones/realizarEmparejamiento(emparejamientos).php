<?php

include_once "../conectarBBDD.php";


function emparejamientos()
{
    $con = conectarBD();

    $valoresMarcados = intval($_REQUEST['valoresMarcados']);

    $NombresJuegos = mysqli_query($con,'SELECT nombre FROM juegos');
    $resultadoNombreJuegos = mysqli_fetch_assoc($NombresJuegos);
    
    mysqli_close($con);


    echo $valoresMarcados;
}

emparejamientos();