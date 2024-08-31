-- Active: 1718017247649@@127.0.0.1@3307

USE ligarunablanca;


-- para configurar la base de datos en español
-- SET lc_time_names = 'es_ES';


CREATE DATABASE ligaRunaBlanca
    DEFAULT CHARACTER SET = 'utf8mb4';


--  drop Table fechas;

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


INSERT INTO jugadores(nombre, apellido1, correoElectronico, contraseña) VALUES
    ("Pilar", "Guapa", "laCarol@gmail.com", sha1(123)),
    ("Paula", "Arnaiz", "laCarol@gmail.com", sha1(123)),
    ("Pedro", "Feo", "laCarol@gmail.com", sha1(123)),
    ("Raquel", "Enana", "laCarol@gmail.com", sha1(123)),
    ("Adrian", "Harry", "laCarol@gmail.com", sha1(123)),
    ("Daniel", "Segundo", "laCarol@gmail.com", sha1(123));




DELETE from jugadores WHERE nombre in("Daniel", "Oriol", "Carol");

select * FROM jugadores;

ALTER TABLE jugadores
ADD permiso VARCHAR(5);


UPDATE jugadores
SET permiso = 'si'
WHERE nombre = "Daniel";



create table juegos (
    idJuego INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    editorial VARCHAR(50),
    minJugadores INT NOT NULL,
    maxJugadores INT NOT NULL,
    mecanica VARCHAR(50),
    edadMinima INT,
    pertenece VARCHAR(50),
    rutaFoto VARCHAR(100),
    rutaManual VARCHAR(100)
) engine=innodb;

ALTER TABLE juegos
ADD COLUMN youtube VARCHAR(255);
-- como meter la fecha "2010-11-05"
SELECT * from juegos where nombre ="Las ruinas perdidas de arnak" or nombre = "Fresco"; 
INSERT INTO juegos (nombre, editorial, minJugadores, maxJugadores,  mecanica, edadMinima, pertenece, rutaFoto, rutaManual) VALUES
    ("Agrícola", "Devir", 1, 5, "Colocación de trabajadores", 12, "Asociacion", "./img/juegos/agricola.jpg", "./reglamentos_Liga/Agricola-reglas.pdf"),
    ("Bunny Kingdom", "IELLO", 2, 4, "Mayorias", 12, "Asociacion", "./img/juegos/bunnyKingdom.jpg", "./reglamentos_Liga/BunnyKingdom_Reglamento.pdf"),
    ("Blood Rage", "Edge", 2, 4, "Mayorias", 14, "Asociacion", "./img/juegos/bloodRage.jpg", "./reglamentos_Liga/blood-rage-reglamento.pdf"),
    ("Dinosaur Island", "Pandasaurus Games", 1, 4, "Colocación de trabajadores, Gestión de recursos", 10, "Asociacion", "./img/juegos/dinosaurIsland.jpg", "./reglamentos_Liga/DINOSAUR_ISLAND_v2.pdf"),
    ("El Grande", "Devir", 2, 5, "Control de áreas, Control de mayorías", 12, "Asociacion", "./img/juegos/elGrande.jpg", "./reglamentos_Liga/ElGrande.pdf"),
    ("Five Tribes", "Days of Wonder", 2, 4, "Colocación de trabajadores", 13, "Asociacion", "./img/juegos/fiveTribes.jpg", "./reglamentos_Liga/Five tribes_Reglas español.pdf"),
    ("Fresco", "Queen Games", 2, 4, "Gestión de recursos", 10, "Asociacion", "./img/juegos/fresco.jpg", "./reglamentos_Liga/fresco-es.pdf"),
    ("Gaia Proyect", "Maldito Games", 1, 5, "Gestión de recursos", 12, "Asociacion","./img/juegos/gaiaPorject.jpg", "./reglamentos_Liga/gaia.pdf"),
    ("Great Western Trail", "Maldito Games", 2, 4, "Construcción de mazo", 14, "Asociacion", "./img/juegos/greatWesternTrail.jpg", "./reglamentos_Liga/GWT.pdf"),
    ("Lacrimosa", "Devir", 3, 5, "Tablero y cartas", 16, "Asociacion", "./img/juegos/lacrimosa.jpg", "./reglamentos_Liga/ES-Lacrimosa.pdf"),
    ("Las ruinas perdidas de arnak", "Devir", 1, 4, "Colocación de trabajadores, Creación de mazo, Gestión de recursos", 14, "Asociacion", "sin asignar", "./reglamentos_Liga/nada.txt"),
    ("Marco Polo", "Devir", 2, 4, "Colocación de dados", 14,"Asociacion", "./img/juegos/marcoPolo.jpg", "./reglamentos_Liga/los-viajes-de-marco-polo.pdf" ),
    ("Photosynthesis", "GDM Games", 2, 4, "Colocación de trabajadores, Gestión de recursos", 10, "Asociacion", "./img/juegos/photosynthesis.jpg", "./reglamentos_Liga/photosynthesis(pagina 13).pdf"),
    ("Russian Railroads", "Devir", 2, 4, "Colocación de trabajadores, Gestión de recursos", 12,"Asociacion", "./img/juegos/russianRailroads.jpg", "./reglamentos_Liga/RussianRailroad_Reglas.pdf"),
    ("Stone Age", "Devir", 2, 4,  "Colocacion de trabajadores", 10, "Asociacion", "./img/juegos/stoneAge.jpg", "./reglamentos_Liga/StoneAge_Reglas_Devir_es.pdf"),
    ("Tzolk'in", "CGE", 2, 4,  "Colocación de trabajadores" , 13, "Asociacion", "./img/juegos/tzolkin.jpg", "./reglamentos_Liga/tzolkin-rules-es.pdf"),
    ("Wingspan", "Stonemaier Games", 1, 5, "Gestion de mano, Drafting", 10, "Asociacion", "./img/juegos/wingspan.jpg", "./reglamentos_Liga/wingspan-instrucciones_.pdf"),
    ("Noria", "Devir", 2, 4, "Colocación de trabajadores", 12, "Asociacion", "./img/juegos/noria.jpg", "./reglamentos_Liga/nada.txt");

UPDATE juegos
SET rutaManual = './reglamentos_Liga/arnak.pdf'
WHERE nombre = "Las ruinas perdidas de arnak";
    

create Table fechasPartidas(
    idfechaPartida INT AUTO_INCREMENT PRIMARY key,
    fecha DATE NOT NULL
) engine=innodb;

INSERT into fechasPartidas (fecha) VALUES ("2024-9-29"), ("2024-9-19"), ("2024-10-29"),("2024-11-29"), ("2024-12-29");
INSERT into fechasPartidas (fecha) VALUES ("2024-6-29");


SELECT DATE_FORMAT(fecha, '%d-%M-%Y') AS fecha_formateada
FROM fechasPartidas 
ORDER BY MONTH(fecha), DAY(fecha);





CREATE TABLE resultados (
    idResultado INT AUTO_INCREMENT PRIMARY KEY,
    idJugador INT NOT NULL,
    idJuego INT NOT NULL,
    idFecha INT NOT NULL,
    puntosLiga  INT NOT NULL,
    puntosJuego INT NOT NULL,
    mesa INT NOT NULL,
    Foreign Key (idJugador) REFERENCES jugadores (idJugador),
    Foreign Key (idJuego) REFERENCES juegos (idJuego),
    Foreign Key (idFecha) REFERENCES fechasPartidas (idfechaPartida)
) engine=innodb;


INSERT INTO resultados (idJugador, idJuego, idFecha, puntosLiga, puntosJuego, mesa) 
VALUES 
(4,1,1,5,240,1),
(5,1,1,3,240,1),
(6,1,1,1,240,1),
(4,2,2,3,240,2),
(5,2,2,1,240,2),
(6,2,2,5,240,2);


TRUNCATE TABLE resultados; -- borramos los resultados y reiniciamos contadores automaticos 


-- calsificacion
SELECT 
        juga.nombre AS nombre_jugador, 
        -- juego.nombre AS nombre_juego, 
        -- fecha.fecha AS fecha_partida, 
        sum(r.puntosLiga) AS puntosLiga,
        sum(r.puntosJuego) AS puntosJuego
        -- r.mesa 
    FROM resultados r
    JOIN jugadores juga ON r.idJugador = juga.idJugador
    JOIN juegos juego ON r.idJuego = juego.idJuego
    JOIN fechasPartidas fecha ON r.idFecha = fecha.idfechaPartida
    GROUP BY nombre_jugador
    ORDER BY puntosLiga DESC;



-- historico de partidas
SELECT 
        CONCAT(juga.nombre, ' ', juga.apellido1) AS  Jugador, 
        juego.nombre AS Juego, 
        DATE_FORMAT(fecha.fecha, '%d-%m-%Y') AS Fecha, 
        r.puntosLiga AS "Puntos Liga",
        r.puntosJuego AS "Puntos Juego",
        r.mesa AS Mesa
    FROM resultados r
    JOIN jugadores juga ON r.idJugador = juga.idJugador
    JOIN juegos juego ON r.idJuego = juego.idJuego
    JOIN fechasPartidas fecha ON r.idFecha = fecha.idfechaPartida
    ORDER BY  Fecha, Mesa, r.puntosLiga DESC;
    

-- asitencia
SELECT juga.nombre AS Jugador, count(r.idJugador) 
    FROM resultados r
    JOIN jugadores juga ON r.idJugador = juga.idJugador
    GROUP BY r.idJugador;





SELECT idfechaPartida, DATE_FORMAT(fecha, "%d-%m-%Y") AS fecha FROM  fechaspartidas ORDER BY MONTH(fecha), DAY(fecha) ;


