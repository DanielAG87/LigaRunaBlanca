

<!-- <!DOCTYPE html>
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
                    <input class="form-control text-center" type="text" id="correo" name="correo" placeholder="Correo" required/> 
                </div>
            </div><br>

            <div class="row " id="centrador">
                <div class="col-md-6 col-sm-6 col-lg-4 col-xs-4">
                    <input class="form-control text-center" type="password" id="contra" name="contra" placeholder="Contraseña" required /> 
                </div>
            </div><br>

            <input type="submit" value="Entrar" class="btn btn-outline-warning" id="bLogin" name="bLogin" />
        </form><br>
        <p id="h1Login">Si no tiene acceso, póngase en contacto con el administrador</p>
        <p id="h1Login">Todos los derechos reservados 2024/2025</p>
    </div>
-->


<?php
session_start();

if (!empty($_REQUEST['bLogin']) && !empty($_REQUEST['correo']) && !empty($_REQUEST['contra'])) {

    include_once "./conectarBBDD.php";
    $pase = false;

    if (!empty($_REQUEST['bLogin']) && !empty($_REQUEST['correo']) && !empty($_REQUEST['contra'])) {

        $correo = $_REQUEST['correo'];
        $contra = sha1($_REQUEST['contra']);


        try {
            $con = conectarBD();
            $filtrar = $con->prepare("SELECT * FROM jugadores  WHERE correoElectronico = ? AND contraseña = ?");
            $filtrar->bind_param("ss", $correo, $contra);
            $filtrar->execute();
            $resultFiltrar = $filtrar->get_result(); 
        } catch (Exception $e) {
            echo "Error : " . $e->getMessage();
        }

        mysqli_close($con);
        if ($resultFiltrar->num_rows === 1) {

            while ($row = $resultFiltrar->fetch_assoc()) {
                $_SESSION['id'] = $row["id_socio"];
                $_SESSION['nombre'] = $row["nombre"];
                $_SESSION['apellido1'] = $row["apellido1"];
                $_SESSION['correo'] = $row["correo"];
                $_SESSION['permiso'] = $row["permiso"];
                // $_SESSION['pase'] = $pase;
            }
            $pase = true;
            header("Location: inicio.php");
            exit;
        }
    }
    else{
        header("Location: index.php");
        exit;
    }
}



if (!empty($_REQUEST['descon']) || empty($_REQUEST) || empty($_SESSION)) { 
    session_destroy();?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Runa Blanca</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="TFGcolor.css" />
        <link rel="icon" href="./img/iconoRuna4.png" type="image/x-icon">
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
            <form method="post" action="index.php">

                <div class="row" id="centrador">
                    <div class=" col-lg-4 col-md-6 col-sm-6  col-xs-4">
                        <input class="form-control text-center" type="text" id="correo" name="correo" placeholder="Correo" required />
                    </div>
                </div><br>

                <div class="row " id="centrador">
                    <div class="col-md-6 col-sm-6 col-lg-4 col-xs-4">
                        <input class="form-control text-center" type="password" id="contra" name="contra" placeholder="Contraseña" required />
                    </div>
                </div><br>

                <input type="submit" value="Entrar" class="btn btn-outline-warning" id="bLogin" name="bLogin" />
            </form><br>
            <p id="h1Login">Si no tiene acceso, póngase en contacto con el administrador</p>
        </div>
    <?php
} ?>
