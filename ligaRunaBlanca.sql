-- Active: 1718017247649@@127.0.0.1@3307
CREATE DATABASE ligaRunaBlanca
    DEFAULT CHARACTER SET = 'utf8mb4';


-- drop Table juegos;

create table jugadores (
    idJugador INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido1 VARCHAR(50) NOT NULL,
    apellido2 VARCHAR(50),
    correoElectronico VARCHAR(50) NOT NULL,
    MiembroAso VARCHAR(50),
    localidad VARCHAR(50),
    contraseña VARCHAR(100) NOT NULL
) engine=innodb;

INSERT INTO jugadores(nombre, apellido1, apellido2, correoElectronico, MiembroAso, localidad, contraseña) VALUES
    ("Daniel", "Agustín", "Arroyo", "danielagustin87@gmail.com", "si", "Guadalajara", sha1(123)),
    ("Oriol", "Torija", "Marrodan", "bury@gmail.com", "si", "Guadalajara", sha1(123)),
    ("Carol", "Yedra", "", "laCarol@gmail.com", "no", "Guadalajara", sha1(123));

DELETE from jugadores WHERE nombre in("Daniel", "Oriol", "Carol");

select * FROM jugadores;

create table juegos (
    idJuego INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    editorial VARCHAR(50),
    minJugadores INT NOT NULL,
    maxJugadores INT NOT NULL,
    mecanica VARCHAR(50),
    edadMinima INT,
    pertenece VARCHAR(50),
    ruta_foto VARCHAR(100)
) engine=innodb;

-- como meter la fecha "2010-11-05"

INSERT INTO juegos (nombre, editorial, minJugadores, maxJugadores,  mecanica, edadMinima, pertenece, ruta_foto) VALUES
    ("Agrícola", "Devir", 1, 5, "Colocación de trabajadores", 12, "Asociacion", "./img/juegos/agricola.jpg"),
    ("Bunny Kingdom", "IELLO", 2, 4, "Mayorias", 12, "Asociacion", "./img/juegos/bunnyKingdom.jpg"),
    ("Blood Rage", "Edge", 2, 4, "Mayorias", 14, "Asociacion", "./img/juegos/bloodRage.jpg"),
    ("Dinosaur Island", "Pandasaurus Games", 1, 4, "Colocación de trabajadores, Gestión de recursos", 10, "Asociacion", "./img/juegos/dinosaurIsland.jpg"),
    ("El Grande", "Devir", 2, 5, "Control de áreas, Control de mayorías", 12, "Asociacion", "./img/juegos/elGrande.jpg"),
    ("Five Tribes", "Days of Wonder", 2, 4, "Colocación de trabajadores", 13, "Asociacion", "./img/juegos/fiveTribes.jpg"),
    ("Fresco", "Queen Games", 2, 4, "Gestión de recursos", 10, "Asociacion", "./img/juegos/fresco.jpg"),
    ("Gaia Proyect", "Maldito Games", 1, 5, "Gestión de recursos", 12, "Asociacion","./img/juegos/gaiaPorject.jpg"),
    ("Great Western Trail", "Maldito Games", 2, 4, "Construcción de mazo", 14, "Asociacion", "./img/juegos/greatWesternTrail.jpg"),
    ("Lacrimosa", "Abba", 3, 5, "Tablero y cartas", 16, "Asociacion", "./img/juegos/lacrimosa.jpg"),
    ("Las ruinas perdidas de arnak", "Devir", 1, 4, "Colocación de trabajadores, Creación de mazo, Gestión de recursos", 14, "Asociacion", "sin asignar"),
    ("Marco Polo", "Devir", 2, 4, "Colocación de dados", 14,"Asociacion", "./img/juegos/marcoPolo.jpg"),
    ("Photosynthesis", "GDM Games", 2, 4, "Colocación de trabajadores, Gestión de recursos", 10, "Asociacion", "./img/juegos/photosynthesis.jpg"),
    ("Russian Railroads", "Devir", 2, 4, "Colocación de trabajadores, Gestión de recursos", 12,"Asociacion", "./img/juegos/russianRailroads.jpg"),
    ("Stone Age", "Devir", 2, 4,  "Colocacion de trabajadores", 10, "Asociacion", "./img/juegos/stoneAge.jpg"),
    ("Tzolk'in", "CGE", 2, 4,  "Colocación de trabajadores" , 13, "Asociacion", "./img/juegos/tzolkin.jpg"),
    ("Wingspan", "Stonemaier Games", 1, 5, "Gestion de mano, Drafting", 10, "Asociacion", "./img/juegos/wingspan.jpg"),
    ("Noria", "Devir", 2, 4, "Colocación de trabajadores", 12, "Asociacion", "./img/juegos/noria.jpg");

create table partida(
    idpartida INT AUTO_INCREMENT PRIMARY KEY,
    juego INT NOT NULL,
    jugador1 INT NOT NULL,
    jugador2 INT NOT NULL,
    jugador3 INT NOT NULL,
    jugador4 INT,
    fecha DATE NOT NULL,
    Foreign Key (juego) REFERENCES juegos (idJuego),
    Foreign Key (jugador1) REFERENCES jugadores (idJugador),
    Foreign Key (jugador2) REFERENCES jugadores (idJugador),
    Foreign Key (jugador3) REFERENCES jugadores (idJugador),
    Foreign Key (jugador4) REFERENCES jugadores (idJugador)
) engine=innodb;



create table puntuaciones (
    idpuntuacion INT AUTO_INCREMENT PRIMARY KEY,
    idpartida INT NOT NULL,
    idJugador int NOT NULL,
    idJuego INT NOT NULL,
    puntuacionJuego INT NOT NULL,
    puntosLiga INT NOT NULL,
    Foreign Key (idpartida) REFERENCES partida (idpartida),
    Foreign Key (idJugador) REFERENCES jugadores (idJugador),
    Foreign Key (idJuego) REFERENCES juegos (idJuego)
) engine=innodb;


create Table fechas(
    idfecha INT AUTO_INCREMENT PRIMARY key,
    fecha DATE NOT NULL,
    participantes INT
) engine=innodb;

    

create Table fechasPartidas(
    idfechaPartida INT AUTO_INCREMENT PRIMARY key,
    fecha DATE NOT NULL
) engine=innodb;

INSERT into fechasPartidas (fecha) VALUES ("2024-9-29"), ("2024-9-19"), ("2024-10-29"),("2024-11-29"), ("2024-12-29");



SELECT DATE_FORMAT(fecha, '%d, %M %Y') AS fecha_formateada
FROM fechasPartidas 
ORDER BY MONTH(fecha), DAY(fecha);

