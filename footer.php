        <div id="azul">
            <div class="container-fluid" id="footer">
                <footer class="py-3 my-4">
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href="inicio.php" class="nav-link px-2  text-white">Inicio</a></li>
                        <li class="nav-item"><a href="ProximasPartidas.php" class="nav-link px-2 text-white">Partidas</a></li>
                        <li class="nav-item"><a href="juegos.php" class="nav-link px-2 text-white">Juegos</a></li>
                        <li class="nav-item"><a href="clasificacion.php" class="nav-link px-2 text-white">Clasificación</a></li>
                        
                        <?php
                                if (strtoupper($_SESSION['permiso']) == "SI") { ?>
                                    <li class="nav-item"><a href="emparejamientos.php" id="blanco" class="nav-link px-2 text-white">Emparejamientos</a></li>
                                 
                                    <li class="nav-item"><a class="nav-link" id="blanco" href="gestion.php">Gestión Liga</a></li> 
                                    <?php
                                } else { ?>
                                    <li class="nav-item"><a id="agotado" class="nav-link px-2 text-white">Emparejamientos</a></li>
                                    <li class="nav-item"> <a class="nav-link" id="agotado">Gestión Liga</a></li>
                                <?php } ?>
                    </ul>
                    <div class="text-center">
                        <span class="text-white" id="spanFooter">© 2023-2026 Asociación Runa Blanca</span>
                        <a class="text-muted" id="" href="https://www.facebook.com/asociacionrunablanca"><i class="bi bi-facebook iconoBlanco"></i></a>
                        <a class="text-muted" href="https://www.instagram.com/asociacion_runa_blanca/"><i class="bi bi-instagram iconoBlanco"></i></a>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>