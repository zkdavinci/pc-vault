-- PC Vault - Examen Final. Instalacion nueva: reemplaza datos existentes.
-- En InfinityFree: crear/seleccionar la BD desde el panel y omitir las 2 lineas siguientes.
CREATE DATABASE IF NOT EXISTS pc_vault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pc_vault;

DROP TABLE IF EXISTS detalle_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS juegos;

CREATE TABLE juegos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    anio SMALLINT UNSIGNED NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Los ratings son valores editoriales provisorios, no puntajes oficiales.
INSERT INTO juegos (nombre, genero, anio, rating, descripcion, imagen, precio) VALUES
('The Witcher 3: Wild Hunt', 'RPG', 2015, 9.8, 'Geralt de Rivia explora un mundo de fantasia lleno de monstruos y decisiones dificiles.', 'img/juegos/witcher3.jpg', 19.99),
('Cyberpunk 2077', 'RPG', 2020, 9.5, 'Un RPG de mundo abierto ambientado en la futurista ciudad de Night City.', 'img/juegos/cyberpunk2077.jpg', 29.99),
('The Elder Scrolls V: Skyrim', 'RPG', 2011, 9.7, 'Una aventura de fantasia donde el Sangre de Dragon descubre los secretos de Skyrim.', 'img/juegos/skyrim.jpg', 14.99),
('Hogwarts Legacy', 'RPG', 2023, 9.0, 'Explora Hogwarts y sus alrededores en una aventura del universo magico.', 'img/juegos/hogwartslegacy.jpg', 39.99),
('Red Dead Redemption 2', 'Accion', 2018, 9.9, 'Arthur Morgan y su banda intentan sobrevivir en los ultimos dias del Viejo Oeste.', 'img/juegos/rdr2.jpg', 29.99),
('Grand Theft Auto V', 'Accion', 2013, 9.6, 'Tres protagonistas se cruzan en una historia criminal en Los Santos.', 'img/juegos/gtav.jpg', 19.99),
('Ghost of Tsushima', 'Accion', 2020, 9.5, 'Jin Sakai defiende la isla de Tsushima durante la invasion mongola.', 'img/juegos/ghostoftsushima.jpg', 39.99),
('Horizon Zero Dawn', 'Accion', 2017, 9.2, 'Aloy investiga un mundo posapocaliptico dominado por maquinas.', 'img/juegos/horizonzerodawn.jpg', 24.99),
('The Last of Us Part I', 'Accion', 2022, 9.8, 'Joel y Ellie atraviesan un mundo devastado en una historia de supervivencia.', 'img/juegos/tlou1.jpg', 49.99),
('The Last of Us Part II Remastered', 'Accion', 2024, 9.7, 'Una historia de supervivencia, perdida y venganza con Ellie y Abby.', 'img/juegos/tlou2.jpg', 49.99),
('Sekiro: Shadows Die Twice', 'Accion', 2019, 9.6, 'Un shinobi lucha contra poderosos enemigos en el Japon feudal.', 'img/juegos/sekiro.jpg', 29.99),
('Battlefield 1', 'Shooter', 2016, 9.2, 'Batallas a gran escala ambientadas en diferentes frentes de la Primera Guerra Mundial.', 'img/juegos/battlefield1.jpg', 14.99),
('Metro Exodus', 'Shooter', 2019, 9.3, 'Artyom abandona el metro de Moscu en busca de un nuevo hogar.', 'img/juegos/metroexodus.jpg', 19.99),
('Forza Horizon 5', 'Carreras', 2021, 9.3, 'Un festival automovilistico de mundo abierto ambientado en Mexico.', 'img/juegos/forzahorizon5.jpg', 39.99),
('Need for Speed Heat', 'Carreras', 2019, 8.6, 'Compite de dia y participa en carreras callejeras nocturnas en Palm City.', 'img/juegos/nfsheat.jpg', 19.99),
('Civilization VI', 'Estrategia', 2016, 9.4, 'Construye una civilizacion desde la antiguedad hasta la era moderna.', 'img/juegos/civilization6.jpg', 29.99),
('Far Cry 5', 'Shooter', 2018, 9.0, 'Libera Hope County de una secta en un mundo abierto de Montana.', 'img/juegos/farcry5.jpg', 19.99),
('Mafia II', 'Accion', 2010, 9.3, 'Vito Scaletta entra en el crimen organizado en Empire Bay.', 'img/juegos/mafia2.jpg', 14.99),
('S.T.A.L.K.E.R. 2: Heart of Chornobyl', 'Shooter', 2024, 9.0, 'Explora la peligrosa Zona de exclusion de Chornobil en busca de artefactos y respuestas.', 'img/juegos/stalker2.jpg', 49.99),
('EA SPORTS FC 27', 'Deportes', 2026, 8.5, 'Simulador de futbol con clubes, selecciones y diferentes modos de juego.', 'img/juegos/fc27.jpg', 59.99);

CREATE TABLE usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedidos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    estado ENUM('Pendiente', 'Entregado', 'Cancelado') NOT NULL DEFAULT 'Pendiente',
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE detalle_pedido (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT UNSIGNED NOT NULL,
    juego_id INT UNSIGNED NULL,
    nombre_juego VARCHAR(150) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (juego_id) REFERENCES juegos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cuentas demo: hashes creados con password_hash(). Claves en entrega privada.
INSERT INTO usuarios (usuario, nombre, email, password_hash, rol) VALUES
('admin_demo', 'Admin Demo', 'admin@example.test', '$2y$10$CScci6Ic3zq3voYeHfI8/OVyBoLe8Hb8ByJTVR5j0zLY.xN1bRYje', 'admin'),
('cliente_demo', 'Cliente Demo', 'cliente@example.test', '$2y$10$BaoTaHMCeKspQ1a629vCSu.foofwnJSginMV9C/7tbXQ3Y2T5v1z.', 'usuario'),
('cliente2_demo', 'Segundo Cliente', 'cliente2@example.test', '$2y$10$IaK5voqv6VukN4K8A0Loc.7ne4ETYbrucwBpWMJ7i6tl.7uy.wtXm', 'usuario');
