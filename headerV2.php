<?php session_start(); ?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="author" content=" Daniel Agustín Arroyo ">
    <meta name="generator" content=" Visual Studio Code ">
    <meta name="date" content=" 20/04/2023">
    <meta name="TFG Daniel Agustín Arroyo " content="TFG 2023">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asociación Runa Blanca</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="TFGcolor.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> <!-- uldimo -->
    <link rel="icon" href="./img/RunaLogo.svg" type="image/x-icon">
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
                                    <a class="nav-link active" id="blanco" aria-current="page" href="inicio.php">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" href="torneos.php">Actividades</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blanco" href="inventario.php">Inventario</a>
                                </li>

                                <?php
                                if ("Si" == "Si") { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="blanco" href="contabilidad.php">Contabilidad</a>

                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="blanco" href="socios.php">Socios</a>
                                    </li> <?php
                                        } else { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="agotado">Contabilidad</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="agotado">Socios</a>
                                    </li>
                                <?php } ?>

                            </ul>

                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-md-2 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center">
                    <span class="pr-3 mr-2 mb-2" id="spanNombre">¡Bienvenido Daniel!</span>
                    <form method="post" action="index.php">
                        <button type="submit" id="descon" name="descon" value="descon" class="btn btn-outline-warning ml-4">Desconectar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<body>
    <div class="content">