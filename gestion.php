<?php include "headerV2.php";
include_once "conectarBBDD.php"; 

$con = conectarBD();

mysqli_close($con); ?>



<div class="container">
    <fieldset>
        <legend>Nuevo movimiento</legend>

        <input type="text" id="nombre" class="form-control" placeholder="Nombre" />
        <input type="text" id="ape1" class="form-control" placeholder="Apellido" />
        <select class="form-select " id="tipoMovimiento">
            <option disabled selected>Selecciona una opción</option>
            <option>Ingreso</option>
            <option>Gasto</option>
            <option>Donación</option>
        </select>
        <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" />
        <input type="text" id="concepto" class="form-control" placeholder="Concepto" />
        <input type="date" id="fecha" class="form-control" placeholder="Fecha" />
        <br />
        <div class="d-flex justify-content-center">
            <button type="button" id="" class="btn btn-outline-primary m-2 " onclick="movimiento()">Hacer movimiento</button>
            <form method="post" action="contabilidad.php">
                <button type="submit" id="vol" class="btn btn-outline-primary m-2">Volver</button>
            </form>
            <button type="submit" id="limpiar" class="btn btn-outline-primary m-2">Limpiar campos</button>
        </div>
    </fieldset>
</div>







<?php include("footer.php"); ?>



<script>
    $(document).ready(function() {
        // codigo para limpiar los campos de los imput
        $(document).ready(function() {
            $("#limpiar").click(function() {
                $("#nombre, #ape1, #cantidad, #concepto, #fecha").val("");
                $("#tipoMovimiento").prop("selectedIndex", 0);

            });
        });
    });
</script>