-- ============================================
-- BASE DE DATOS: TIENDA DE INFORMATICA
-- Motor: MySQL 8
-- ============================================

DROP DATABASE IF EXISTS tienda_informatica;

CREATE DATABASE tienda_informatica
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tienda_informatica;


-- ============================================
-- 1. TABLA: USUARIOS
-- ============================================

CREATE TABLE usuarios (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    rol TINYINT NOT NULL COMMENT '0: Administrador, 1: Usuario',
    contrasenia VARCHAR(255) NOT NULL COMMENT 'Hash generado con password_hash() (bcrypt, 60 caracteres)',
    apellidos VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- ============================================
-- 2. TABLA: PRODUCTOS
-- ============================================

CREATE TABLE productos (
    id_producto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    marca VARCHAR(60) NOT NULL,
    modelo VARCHAR(100),
    precio DECIMAL(10, 2) NOT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 0,

    CONSTRAINT chk_producto_precio
        CHECK (precio >= 0)
);


-- ============================================
-- 3. TABLA: DETALLES_PRODUCTO
-- Relacion 1:1 con PRODUCTOS
-- ============================================

CREATE TABLE detalles_producto (
    id_detalle_producto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_producto INT UNSIGNED NOT NULL UNIQUE,
    peso DECIMAL(8, 2) NOT NULL COMMENT 'Peso en gramos',
    alto DECIMAL(8, 2) NOT NULL COMMENT 'Altura en milimetros',
    ancho DECIMAL(8, 2) NOT NULL COMMENT 'Anchura en milimetros',
    profundidad DECIMAL(8, 2) NOT NULL COMMENT 'Profundidad en milimetros',

    CONSTRAINT fk_detalles_producto_productos
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT chk_detalles_producto_peso
        CHECK (peso > 0),

    CONSTRAINT chk_detalles_producto_alto
        CHECK (alto > 0),

    CONSTRAINT chk_detalles_producto_ancho
        CHECK (ancho > 0),

    CONSTRAINT chk_detalles_producto_profundidad
        CHECK (profundidad > 0)
);


-- ============================================
-- 4. TABLA: PEDIDOS
-- ============================================

CREATE TABLE pedidos (
    id_pedido INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    fecha_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado ENUM(
        'pendiente',
        'confirmado',
        'pagado',
        'enviado',
        'entregado',
        'cancelado'
    ) NOT NULL DEFAULT 'pendiente',

    CONSTRAINT fk_pedidos_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);


-- ============================================
-- 5. TABLA: DETALLES_PEDIDO
-- ============================================

CREATE TABLE detalles_pedido (
    id_detalle INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    precio_compra DECIMAL(10, 2) NOT NULL,

    CONSTRAINT fk_detalles_pedidos
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_detalles_productos
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT chk_detalle_cantidad
        CHECK (cantidad > 0),

    CONSTRAINT chk_detalle_precio
        CHECK (precio_compra >= 0),

    CONSTRAINT uq_pedido_producto
        UNIQUE (id_pedido, id_producto)
);


-- ============================================
-- INSERCIONES: USUARIOS (0: Admin, 1: Usuario)
-- Todas las contraseñas son "1234", guardadas como hash bcrypt (password_hash)
-- ============================================

INSERT INTO usuarios
(id_usuario, nombre, rol, contrasenia, apellidos, email, telefono)
VALUES
(1, 'Carlos', 0, '$2y$10$9Y73253vR39JqTF/3JIYpOEsrd19V76lGlSBL15aiYPRYpRgsFAzW', 'Garcia Lopez', 'carlos@gmail.com', '600123456'), -- Administrador (sin pedidos)
(2, 'Laura', 1, '$2y$10$2uqeB5DyKFFGcZ1udvaaC.Nt2fgU5DUPdijg9XdjkMUWyFsbQN1Qm', 'Martinez Perez', 'laura@gmail.com', '611234567'),   -- Usuario
(3, 'Javier', 0, '$2y$10$a8LSkixwpcguBVVmgaRJhOqkqZut4JjAfwjAV4bDRdzvQtg8b2E3a', 'Sanchez Ruiz', 'javier@gmail.com', '622345678'),   -- Administrador (sin pedidos)
(4, 'Ana', 1, '$2y$10$KQg6aACgjuNZ78EJ4ClYgO8szUl6lnbbpQo9BbzLSRfcNg/yJ9Gvu', 'Fernandez Diaz', 'ana@gmail.com', '633456789');       -- Usuario


-- ============================================
-- INSERCIONES: PRODUCTOS
-- ============================================

INSERT INTO productos
(id_producto, nombre, categoria, marca, modelo, precio, stock)
VALUES
(1, 'Tarjeta grafica RTX 4070', 'Tarjetas graficas', 'NVIDIA', 'RTX 4070', 599.99, 15),
(2, 'Procesador Ryzen 7 7800X3D', 'Procesadores', 'AMD', '7800X3D', 399.99, 10),
(3, 'Memoria RAM DDR5 32GB', 'Memoria RAM', 'Corsair', 'Vengeance 32GB DDR5', 119.99, 25),
(4, 'Monitor Gaming 27 pulgadas', 'Monitores', 'LG', '27GP850', 299.99, 8);


-- ============================================
-- INSERCIONES: DETALLES_PRODUCTO
-- ============================================

INSERT INTO detalles_producto
(id_detalle_producto, id_producto, peso, alto, ancho, profundidad)
VALUES
(1, 1, 1200.00, 120.00, 300.00, 50.00),
(2, 2, 100.00, 40.00, 40.00, 40.00),
(3, 3, 80.00, 35.00, 135.00, 7.00),
(4, 4, 6000.00, 365.00, 614.00, 57.00);


-- ============================================
-- INSERCIONES: PEDIDOS (Solo realizados por usuarios con rol 1)
-- ============================================

INSERT INTO pedidos
(id_pedido, id_usuario, fecha_pedido, estado)
VALUES
(1, 2, '2026-10-24 12:15:00', 'pagado'),     -- Pedido de Laura (Usuario) con múltiples productos
(2, 4, '2026-10-26 09:00:00', 'pendiente'),  -- Pedido de Ana (Usuario) con un solo producto
(3, 2, '2026-10-27 14:00:00', 'enviado');    -- Segundo pedido de Laura (Usuario) con un solo producto


-- ============================================
-- INSERCIONES: DETALLES_PEDIDO (Simulando varios productos en un mismo pedido)
-- ============================================

INSERT INTO detalles_pedido
(id_detalle, id_pedido, id_producto, cantidad, precio_compra)
VALUES
(1, 1, 1, 1, 599.99), -- Pedido 1: Incluye Tarjeta gráfica RTX 4070
(2, 1, 3, 2, 119.99), -- Pedido 1: Incluye 2 unidades de Memoria RAM DDR5 32GB
(3, 2, 4, 1, 299.99), -- Pedido 2: Incluye Monitor Gaming 27 pulgadas
(4, 3, 2, 1, 399.99); -- Pedido 3: Incluye Procesador Ryzen 7 7800X3D
