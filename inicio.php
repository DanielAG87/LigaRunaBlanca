<?php
include "headerV2.php";

?>
<!-- Carrusel -->
<div class="container-fluid">
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>

    </div>
    <div class="carousel-inner mb-2">
      <div class="carousel-item active " data-bs-interval="3000">
        <img src="./img/aso4Runa.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item" data-bs-interval="3000">
        <img src="./img/aso7.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item" data-bs-interval="3000">
        <img src="./img/asoSolidaria.jpg" class="d-block w-100" alt="...">
      </div>

      <div class="carousel-item" data-bs-interval="3000">
        <img src="./img/aso6.jpg" class="d-block w-100" alt="...">
      </div>
      <!-- <div class="carousel-item" data-bs-interval="3000">
        <img src="./img/aso9.jpg" class="d-block w-100" alt="...">
      </div> -->
      <div class="carousel-item" data-bs-interval="3000">
        <img src="./img/terra.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>
</div>
<!-- Fin Carusel -->


<div class="container-fluid pt-6 pr-2" id="mapaDatos">
  <div class="row align-items-center">
    <div class="col-md-6">
      <div class="d-flex justify-content-center">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3026.0942591174557!2d-3.205867924184407!3d40.671892040070325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd43ae9dfc20b7c9%3A0x6fb360757addb6bc!2sEspacio%20para%20la%20Creaci%C3%B3n%20Joven!5e0!3m2!1ses!2ses!4v1685301414359!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>

    

    <div class="col-md-6 p-md-3 pt-5">
      <div class="row "> <!-- align-items-center -->
        <!-- <div class="col-md-6 pb-5" id="datoAso">
          <h3 class=""><u>Junta Directiva</u></h3><br />
          <p><strong>Líder Supremo:</strong> <em>Julio Cesar de Roma</em></p>
          <p><strong>Vicepresidente: </strong><em>Rubén Gómez Martínez</em></p>
          <p><strong>Secretario: </strong><em>Sofía López González</em></p>
          <p><strong>Organizador: </strong><em>Daniel Agustín Arroyo</em></p>
        </div> -->

        <!-- <div class="col-md-6 pb-5 d-flex flex-column align-items-center" id="datoAso" >
          <h3 class=""><u>Colaboradores</u></h3><br />
          <img src="./img/logo centro joven.png" class="d-block w-20" alt="..." style="width: 32%;"> </br>
          <img src="./img/logo Marchamalo.png" class="d-block w-20" alt="..."> </br>
          <img src="./img/logo dark comic.jpeg" class="d-block w-20" alt="..." style="width: 32%;"> </br>
          <img src="./img/jupiter.jpg" class="d-block w-20" alt="..." style="width: 32%;"> </br>
        </div> -->
        <div class="col-md-6 pb-5 pl-1" id="datoAso">
          <h3 class="text-center"><u>Colaboradores</u></h3><br />
          <div class="row">
            <div class="col-6 d-flex justify-content-center">
              <img src="./img/logo centro joven.png" class="d-block w-100" alt="..." style="width: 100%; height: 80%;">
            </div>
            <div class="col-6 d-flex justify-content-center">
              <img src="./img/logo Marchamalo.png" class="d-block w-75" alt="..." style="width: 100%; height: 90%;">
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-6 d-flex justify-content-center">
              <img src="./img/logo dark comic.jpeg" class="d-block w-75" alt="..." style="width: 70%;">
            </div>
            <div class="col-6 d-flex justify-content-center">
              <img src="./img/jupiter.jpg" class="d-block w-75" alt="..." style="width: 70%;">
            </div>
          </div>
        </div>


        <div class="col-md-6 datoAso2" id="datoAso">
          <h3 class=""><u>Datos Asociación</u></h3><br />
          <!-- <p><strong>Domicilio: </strong><em>Calle de los músicos, 2 19180 Marchamalo, Guadalajara </em></p> -->
          <p><strong>Correo: </strong><em>runablanca@gmail.com</em></p>
          <!-- <p><strong>CIF: </strong><em>82080366J </em></p>   -->
          <p><strong>Correo liga: </strong><em>liga.runablanca@gmail.com </em></p>
          <p><strong>Organización liga: </strong><em>Daniel Agustín </em></p>
          <p><strong>Organización liga: </strong><em>Oriol Torija </em></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include "footer.php";
?>
