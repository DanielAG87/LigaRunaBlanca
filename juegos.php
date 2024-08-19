<?php include "headerV2.php";
include_once "conectarBBDD.php"; 

$con = conectarBD();
$juegos = mysqli_query($con, 'SELECT * FROM  juegos;');

$devolverJuegos = mysqli_fetch_all($juegos);
mysqli_close($con);
?>

<!-- printamos la informacion de cada juego con el boton de descargas -->
<div class="container-fluid" id="tablaJuegos">
    <div class="row">
        <?php
        foreach ($devolverJuegos as $j) {?>
            <div class=" col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 col-xxl-2 text-center mb-3">
                <span style="text-align: center;"><strong><?= $j[1] ?></strong></span><br />
                <img style="width: 200px; height: 200px;" src="<?= $j[8] ?>" /><br />
                <span>Jugadores: <?= $j[3] ?>-<?= $j[4] ?></span><br />
                <span>Edad mínima: <?= $j[6] ?></span><br />
                <button class="btn btn-outline-primary">
                    <a href="<?php echo $j[9] ?>" download="Reglas <?= $j[1] ?>" style="text-decoration: none;"> Descargar Manual </a>
                </button>
            </div>
        <?php } ?>
    </div>
</div>


<?php include("footer.php"); ?>