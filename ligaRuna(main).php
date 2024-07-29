

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Runa Blanca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="TFGcolor.css" />
    <link rel="icon" href="./img/RunaLogo.svg" type="image/x-icon">
    <style>
        #h1Login {
            color: whitesmoke;
            padding-bottom: 5px;
            font-family: Viking;
        }
    </style>
</head>

<body class="text-center" id="bodyLogin">

    <div class="container-fluid " id="login1">
        <h1 class="h1 pb-3 " id="h1Login">Asociación Runa Blanca</h1>
        <img id="loginIMG" src="./img/iconoRuna5.png" />
        <h4 class="h4" id="h1Login">Login</h4>
        <form method="post" action="inicio.php">

            <div class="row" id="centrador">
                <div class=" col-lg-4 col-md-6 col-sm-6  col-xs-4">
                    <input class="form-control text-center" type="text" id="correo" name="correo" placeholder="Correo"/> <!-- required -->
                </div>
            </div><br>

            <div class="row " id="centrador">
                <div class="col-md-6 col-sm-6 col-lg-4 col-xs-4">
                    <input class="form-control text-center" type="password" id="contra" name="contra" placeholder="Contraseña" /> <!-- required -->
                </div>
            </div><br>

            <input type="submit" value="Entrar" class="btn btn-outline-warning" id="bLogin" name="bLogin" />
        </form><br>
        <p id="h1Login">Si no tiene acceso, póngase en contacto con el administrador</p>
        <p id="h1Login">Todos los derechos reservados 2024/2025</p>
    </div>
<?php

