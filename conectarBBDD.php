<?php 
function conectarBD(){
    // $servidor = "localhost";
    // $usuario = 'rb_admin';
    // $pass = "Agustin_1987";
    // $baseDatos = "RunaBlanca_DB";
    // $puerto = 3306;

    // $conexion = mysqli_connect($servidor, $usuario, $pass, $baseDatos, $puerto);
    // if (!$conexion) {
    //     echo 'No se puede establecer conexión';
    // }
    // else{
    //     return $conexion;
    // }




    // para local
    // $conexion = new mysqli("127.0.0.1", "root", "", "ligarunablanca2",3307);
 

    // // Check connection
    // if ($conexion->connect_error) {
    //     die("Connection failed: " . $conexion->connect_error);
    // }

    // return $conexion;




    // MySQLi (Object-Oriented)
    $conexion = new mysqli("localhost:3306", "rb_admin", "Agustin_1987", "RunaBlanca_DB");

    // Check connection
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }
    // Establecer el charset a utf8
    if (!$conexion->set_charset("utf8")) {
        die("Error al cargar el conjunto de caracteres utf8: " . $conexion->error);
    }
        // Close the connection
    return $conexion;
} 







?>