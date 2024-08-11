<?php 
function conectarBD(){
    $servidor = "127.0.0.1";
    $usuario = 'root';
    $pass = "";
    $baseDatos = "ligarunablanca";
    $puerto = 3307;

    $conexion = mysqli_connect($servidor, $usuario, $pass, $baseDatos, $puerto);
    if (!$conexion) {
        echo 'No se puede establecer conexión';
    }
    else{
        return $conexion;
    }
} ?>