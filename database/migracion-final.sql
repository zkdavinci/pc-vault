-- Aplicar UNA SOLA VEZ sobre la BD existente tras hacer backup.
-- En InfinityFree seleccionar la BD desde phpMyAdmin antes de importar.
ALTER TABLE juegos ADD COLUMN precio DECIMAL(10,2) NOT NULL DEFAULT 0,
                   ADD COLUMN activo TINYINT(1) NOT NULL DEFAULT 1;
UPDATE juegos SET precio = CASE id
    WHEN 1 THEN 19.99
    WHEN 2 THEN 29.99
    WHEN 3 THEN 14.99
    WHEN 4 THEN 39.99
    WHEN 5 THEN 29.99
    WHEN 6 THEN 19.99
    WHEN 7 THEN 39.99
    WHEN 8 THEN 24.99
    WHEN 9 THEN 49.99
    WHEN 10 THEN 49.99
    WHEN 11 THEN 29.99
    WHEN 12 THEN 14.99
    WHEN 13 THEN 19.99
    WHEN 14 THEN 39.99
    WHEN 15 THEN 19.99
    WHEN 16 THEN 29.99
    WHEN 17 THEN 19.99
    WHEN 18 THEN 14.99
    WHEN 19 THEN 49.99
    WHEN 20 THEN 59.99
    ELSE 19.99 END;


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
