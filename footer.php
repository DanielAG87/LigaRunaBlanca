        <div id="azul">
            <div class="container-fluid" id="footer">
                <footer class="py-3 my-4">
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href="inicio.php" class="nav-link px-2  text-white">Inicio</a></li>
                        <li class="nav-item"><a href="torneos.php" class="nav-link px-2 text-white">Actividades</a></li>
                        <li class="nav-item"><a href="inventario.php" class="nav-link px-2 text-white">Inventario</a></li>
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
                    <div class="text-center">
                        <span class="text-white" id="spanFooter">© 2023-2025 Asociación Runa Blanca</span>
                        <a class="text-muted" id="" href="https://www.facebook.com/asociacionrunablanca"><i class="bi bi-facebook iconoBlanco"></i></a>
                        <a class="text-muted" href="https://www.instagram.com/asociacion_runa_blanca/"><i class="bi bi-instagram iconoBlanco"></i></a>
                    </div>
                </footer>
            </div>
        </div>
       
    </body>
</html>