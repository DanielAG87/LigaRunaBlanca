<?php session_start(); 
if(empty($_SESSION['nombre'])){
    header("Location: index.php");
    exit;
}


// Establecer el límite de inactividad en segundos (2 horas = 7200 segundos)
// $limite_inactividad = 7200;
$limite_inactividad = 7200;

// Verificar si hay actividad previa
if (isset($_SESSION['ultima_actividad'])) {
    // Calcular el tiempo de inactividad
    $tiempo_inactivo = time() - $_SESSION['ultima_actividad'];

    // Si ha pasado más de $limite_inactividad segundos, desloguear
    if ($tiempo_inactivo > $limite_inactividad) {
        // Destruir la sesión y redirigir al usuario a la página de login
        session_unset(); // Limpiar las variables de sesión
        session_destroy(); // Destruir la sesión
        header("Location: index.php"); // Redirigir al login
        exit(); // Detener la ejecución del script
    }
}

// Actualizar el tiempo de la última actividad
$_SESSION['ultima_actividad'] = time();
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content=" Daniel Agustín Arroyo ">
    <meta name="generator" content=" Visual Studio Code ">
    <meta name="date" content=" 20/04/2023">
    <meta name="TFG Daniel Agustín Arroyo " content="TFG 2023">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Runa Blanca</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="TFGcolor.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> <!-- ultimo -->
    <link rel="icon" href="./img/iconoRuna4.png" type="image/x-icon">
</head>

<div id="azul" class="mb-3">
    <div class="container-fluid pt-30" id="navbar">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <nav class="navbar navbar-expand-sm navbar-center justify-content ">
                    <div class="container-fluid">
                        <a class="navbar-brand  " href="inicio.php">
                            <img src="./img/iconoRuna5.png" class="d-block w-10 " id="logoHeader" alt="..."> <!--Logo -->
                        </a>
                        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-filter" viewBox="0 0 16 16">
                                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" aria-current="page" href="inicio.php">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" href="ProximasPartidas.php">Partidas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" href="juegos.php">Juegos</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" id="blanco" href="clasificacion.php">Clasificación</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" href="emparejamientos.php">Emparejamientos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" href="miLiga.php">Mi Liga</a>
                                </li>
                           

                                <?php
                                if (strtoupper($_SESSION['permiso']) == "SI") { ?>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" id="blanco" href="gestion.php">Gestión Liga</a>
                                    </li> <?php
                                } else { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="agotado">Gestión Liga</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- <div class="col-md-2 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center">
                    <span class="pr-3 mr-2 mb-2" id="spanNombre">Bienvenido/a <?=$_SESSION['nombre']?></span>
                    <form method="post" action="index.php">
                        <button type="submit" id="descon" name="descon" value="descon" class="btn btn-outline-warning ml-4">Cambiar contraseña</button>
                        <button type="submit" id="descon" name="descon" value="descon" class="btn btn-outline-warning ml-4">Desconectar</button>
                    </form>
                </div>
            </div> -->

            <!-- <div class="col-md-2 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <span class="mb-3 mt-1" id="spanNombre">Bienvenido/a <?=$_SESSION['nombre']?></span>
                    <form method="post" action="index.php" class="d-flex flex-column align-items-center">
                        <button type="submit" id="descon" name="descon" value="descon" class="btn btn-outline-warning mb-2">Cambiar contraseña</button>
                        <button type="submit" id="descon" name="descon" value="descon" class="btn btn-outline-warning mb-2" onclick="cambiarContrasenia()">Desconectar</button>
                    </form>
                </div>
            </div> -->


            <!-- Botón para abrir el modal -->
            <div class="col-md-2 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <span class="mb-3" id="spanNombre">Bienvenido/a <?=$_SESSION['nombre']?></span>
                    <form method="post" action="index.php" class="d-flex flex-column align-items-center">
                        <!-- Botón para activar el modal -->
                        <!-- <button type="button" class="btn btn-outline-warning mb-2" data-bs-toggle="modal" data-bs-target="#cambiarContrasenaModal">
                            Cambiar contraseña
                        </button> -->
                        <!-- Botón para desconectar -->
                        <button type="submit" id="descon" name="descon" value="descon" class="btn btn-outline-warning mb-2">Desconectar</button>
                    </form>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="cambiarContrasenaModal" tabindex="-1" aria-labelledby="cambiarContrasenaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarContrasenaModalLabel">Cambiar contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí puedes agregar tu formulario para cambiar la contraseña -->
                        <form method="post" action="cambiar_contrasena.php">
                            <div class="mb-3">
                                <label for="contraseniaActual" class="form-label">Contraseña actual</label>
                                <input type="password" class="form-control" id="contraseniaActual" name="contraseniaActual" required>
                            </div>
                            <div class="mb-3">
                                <label for="nuevaContra" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" id="nuevaContra" name="nuevaContra" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmarContra" class="form-label">Confirmar nueva contraseña</label>
                                <input type="password" class="form-control" id="confirmarContra" name="confirmarContra" required>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="cambiarContrasenia()">Guardar cambios</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<body>
    <div class="content">


<script>
    function cambiarContrasenia(){
    var contraActual = document.getElementById("contraseniaActual").value;
    var nuevaContra1 = document.getElementById("nuevaContra").value;
    var nuevacontra2 = document.getElementById("confirmarContra").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.body.insertAdjacentHTML('beforeend', this.responseText);
            // Muestra el modal
            var modalContra = new bootstrap.Modal(document.getElementById('modalCambioContra-22'));
            modalContra.show();
        }
    };
    xhttp.open("POST", "funciones/cambioContrasenia(headerV2).php?contraActual=" + contraActual + "&nuevaContra1=" + nuevaContra1 + "&nuevacontra2=" + nuevacontra2, true);
    xhttp.send();
}  
</script>