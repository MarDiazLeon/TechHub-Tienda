CREATE DATABASE IF NOT EXISTS techhub_db;
USE techhub_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR (100) NOT NULL,
    email VARCHAR (100) NOT NULL UNIQUE,
    password VARCHAR (255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio INT NOT NULL,
    imagen VARCHAR(255),
    stock INT DEFAULT 15
);

CREATE TABLE IF NOT EXISTS ordenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    total INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS detalle_orden (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orden_id INT,
    producto_id INT,
    cantidad INT NOT NULL,
    precio_unitario INT NOT NULL,
    FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);


INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES
('Audifonos Inalámbricos', 'Audífonos Bluetooth con cancelación de ruido', 30000, 'Audifonos.jpg'),
('Monitor 24" Full HD', 'Monitor ideal para diseño y desarrollo.', 120000, 'Monitor.jpg'),
('Mouse Ergonómico', 'Mouse inalámbrico con alta precisión DPI.', 25000, 'Mouse.jpg'),
('Soporte para Laptop', 'Soporte de aluminio ajustable para mejorar la postura.', 15000, 'Soporte.jpg');
