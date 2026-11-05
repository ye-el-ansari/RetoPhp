
-- ============================================
-- BASE DE DATOS: TIENDA DE INFORMATICA
-- Motor: MySQL 8
-- ============================================

CREATE DATABASE IF NOT EXISTS tienda_informatica
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tienda_informatica;


-- ============================================
-- 1. TABLA: USUARIOS
-- ============================================

CREATE TABLE usuarios (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    rol VARCHAR NOT NULL,
    contrasenia VARCHAR(80) NOT NULL,
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
        'pagado',
        'enviado',
        'entregado',
        'cancelado'
    ) NOT NULL DEFAULT 'pendiente',

    CONSTRAINT fk_pedidos_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE   -- antes: RESTRICT
);


-- ============================================
-- 5. TABLA: DETALLES_PEDIDO
-- ============================================

CREATE TABLE detalles_pedido (
    id_detalle INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,

    CONSTRAINT fk_detalles_pedidos
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_detalles_productos
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON UPDATE CASCADE
        ON DELETE CASCADE,  -- antes: RESTRICT

    CONSTRAINT chk_detalle_cantidad
        CHECK (cantidad > 0),

    CONSTRAINT chk_detalle_precio
        CHECK (precio_unitario >= 0),

    CONSTRAINT uq_pedido_producto
        UNIQUE (id_pedido, id_producto)
);

-- ============================================
-- INSERCIONES: USUARIOS (4 REGISTROS)
-- ============================================

INSERT INTO usuarios
(id_usuario, nombre, apellidos, email, telefono)
VALUES
(1, 'Carlos', 1, '1234', 'Garcia Lopez', 'carlos@gmail.com', '600123456'),
(2, 'Laura', 0, '1234','Martinez Perez', 'laura@gmail.com', '611234567'),
(3, 'Javier', 1, '1234', 'Sanchez Ruiz', 'javier@gmail.com', '622345678'),
(4, 'Ana', 1, '1234', 'Fernandez Diaz', 'ana@gmail.com', '633456789');


-- ============================================
-- INSERCIONES: PRODUCTOS (4 REGISTROS)
-- ============================================

INSERT INTO productos
(id_producto, nombre, categoria, marca, modelo, precio, stock)
VALUES
(1, 'Tarjeta grafica RTX 4070', 'Tarjetas graficas',
 'NVIDIA', 'RTX 4070', 599.99, 15),

(2, 'Procesador Ryzen 7 7800X3D', 'Procesadores',
 'AMD', '7800X3D', 399.99, 10),

(3, 'Memoria RAM DDR5 32GB', 'Memoria RAM',
 'Corsair', 'Vengeance 32GB DDR5', 119.99, 25),

(4, 'Monitor Gaming 27 pulgadas', 'Monitores',
 'LG', '27GP850', 299.99, 8);


-- ============================================
-- INSERCIONES: DETALLES_PRODUCTO (4 REGISTROS)
-- ============================================

INSERT INTO detalles_producto
(id_detalle_producto, id_producto, peso, alto, ancho, profundidad)
VALUES
(1, 1, 1200.00, 120.00, 300.00, 50.00),
(2, 2, 100.00, 40.00, 40.00, 40.00),
(3, 3, 80.00, 35.00, 135.00, 7.00),
(4, 4, 6000.00, 365.00, 614.00, 57.00);


-- ============================================
-- INSERCIONES: PEDIDOS (4 REGISTROS)
-- ============================================

INSERT INTO pedidos
(id_pedido, id_usuario, fecha_pedido, estado)
VALUES
(1, 1, '2026-10-20 10:30:00', 'entregado'),
(2, 1, '2026-10-22 16:45:00', 'enviado'),
(3, 2, '2026-10-24 12:15:00', 'pagado'),
(4, 3, '2026-10-26 09:00:00', 'pendiente');


-- ============================================
-- INSERCIONES: DETALLES_PEDIDO (4 REGISTROS)
-- ============================================

INSERT INTO detalles_pedido
(id_detalle, id_pedido, id_producto, cantidad, precio_unitario)
VALUES
(1, 1, 1, 1, 599.99),
(2, 1, 3, 2, 109.99),
(3, 2, 2, 1, 399.99),
(4, 3, 4, 1, 299.99);
