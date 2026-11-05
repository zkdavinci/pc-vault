-- PC Vault - Segundo Parcial de Programacion Web II
-- Catalogo de 20 videojuegos seleccionados
-- Importar dentro de una base de datos ya creada (pc_vault en local)
-- ATENCION: al volver a importar, se elimina la tabla juegos anterior.

DROP TABLE IF EXISTS juegos;

CREATE TABLE juegos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    anio SMALLINT UNSIGNED NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Los ratings son valores editoriales provisorios, no puntajes oficiales.
INSERT INTO juegos (nombre, genero, anio, rating, descripcion, imagen) VALUES
('The Witcher 3: Wild Hunt', 'RPG', 2015, 9.8, 'Geralt de Rivia explora un mundo de fantasia lleno de monstruos y decisiones dificiles.', 'img/juegos/witcher3.jpg'),
('Cyberpunk 2077', 'RPG', 2020, 9.5, 'Un RPG de mundo abierto ambientado en la futurista ciudad de Night City.', 'img/juegos/cyberpunk2077.jpg'),
('The Elder Scrolls V: Skyrim', 'RPG', 2011, 9.7, 'Una aventura de fantasia donde el Sangre de Dragon descubre los secretos de Skyrim.', 'img/juegos/skyrim.jpg'),
('Hogwarts Legacy', 'RPG', 2023, 9.0, 'Explora Hogwarts y sus alrededores en una aventura del universo magico.', 'img/juegos/hogwartslegacy.jpg'),
('Red Dead Redemption 2', 'Accion', 2018, 9.9, 'Arthur Morgan y su banda intentan sobrevivir en los ultimos dias del Viejo Oeste.', 'img/juegos/rdr2.jpg'),
('Grand Theft Auto V', 'Accion', 2013, 9.6, 'Tres protagonistas se cruzan en una historia criminal en Los Santos.', 'img/juegos/gtav.jpg'),
('Ghost of Tsushima', 'Accion', 2020, 9.5, 'Jin Sakai defiende la isla de Tsushima durante la invasion mongola.', 'img/juegos/ghostoftsushima.jpg'),
('Horizon Zero Dawn', 'Accion', 2017, 9.2, 'Aloy investiga un mundo posapocaliptico dominado por maquinas.', 'img/juegos/horizonzerodawn.jpg'),
('The Last of Us Part I', 'Accion', 2022, 9.8, 'Joel y Ellie atraviesan un mundo devastado en una historia de supervivencia.', 'img/juegos/tlou1.jpg'),
('The Last of Us Part II Remastered', 'Accion', 2024, 9.7, 'Una historia de supervivencia, perdida y venganza con Ellie y Abby.', 'img/juegos/tlou2.jpg'),
('Sekiro: Shadows Die Twice', 'Accion', 2019, 9.6, 'Un shinobi lucha contra poderosos enemigos en el Japon feudal.', 'img/juegos/sekiro.jpg'),
('Battlefield 1', 'Shooter', 2016, 9.2, 'Batallas a gran escala ambientadas en diferentes frentes de la Primera Guerra Mundial.', 'img/juegos/battlefield1.jpg'),
('Metro Exodus', 'Shooter', 2019, 9.3, 'Artyom abandona el metro de Moscu en busca de un nuevo hogar.', 'img/juegos/metroexodus.jpg'),
('Forza Horizon 5', 'Carreras', 2021, 9.3, 'Un festival automovilistico de mundo abierto ambientado en Mexico.', 'img/juegos/forzahorizon5.jpg'),
('Need for Speed Heat', 'Carreras', 2019, 8.6, 'Compite de dia y participa en carreras callejeras nocturnas en Palm City.', 'img/juegos/nfsheat.jpg'),
('Civilization VI', 'Estrategia', 2016, 9.4, 'Construye una civilizacion desde la antiguedad hasta la era moderna.', 'img/juegos/civilization6.jpg'),
('Far Cry 5', 'Shooter', 2018, 9.0, 'Libera Hope County de una secta en un mundo abierto de Montana.', 'img/juegos/farcry5.jpg'),
('Mafia II', 'Accion', 2010, 9.3, 'Vito Scaletta entra en el crimen organizado en Empire Bay.', 'img/juegos/mafia2.jpg'),
('S.T.A.L.K.E.R. 2: Heart of Chornobyl', 'Shooter', 2024, 9.0, 'Explora la peligrosa Zona de exclusion de Chornobil en busca de artefactos y respuestas.', 'img/juegos/stalker2.jpg'),
('EA SPORTS FC 27', 'Deportes', 2026, 8.5, 'Simulador de futbol con clubes, selecciones y diferentes modos de juego.', 'img/juegos/fc27.jpg');
