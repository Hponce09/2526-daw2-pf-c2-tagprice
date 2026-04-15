CREATE DATABASE IF NOT EXISTS anti_inflacion;
USE anti_inflacion;

-- 1. TABLA DE USUARIOS
CREATE TABLE IF NOT EXISTS users (
    usu_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    usu_mail VARCHAR(50) NOT NULL UNIQUE,
    usu_password VARCHAR(255) NOT NULL,
    usu_name VARCHAR(200) NOT NULL,
    usu_rol TEXT NOT NULL DEFAULT 'user' -- Por defecto, todos son usuarios
);

-- 2. TABLA DE PRODUCTOS (Info general)
CREATE TABLE IF NOT EXISTS product (
    product_id INTEGER PRIMARY KEY NOT NULL AUTOINCREMENT,
    nombre VARCHAR(255),
    imagen VARCHAR(255),
    url_compra TEXT, -- TEXT porque las URLs de tiendas son larguísimas
    precio_actual DECIMAL(10,2)
);

-- 3. TABLA DE TALLAS (Relación 1:N con producto)
CREATE TABLE IF NOT EXISTS sizes (
    id_talla INTEGER PRIMARY KEY NOT NULL AUTOINCREMENT,
    id_product INT NOT NULL,
    talla_valor VARCHAR(20), -- Ej: "42", "L", "S"
    stock INT DEFAULT 0,
    FOREIGN KEY (id_product) REFERENCES product(product_id) ON DELETE CASCADE
);

-- 4. TABLA INTERMEDIA DE FAVORITOS (Relación N:M entre users y product)
CREATE TABLE IF NOT EXISTS favorites (
    favoritos_id INTEGER PRIMARY KEY NOT NULL AUTOINCREMENT,
    usu_id INT NOT NULL,
    product_id INT NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usu_id) REFERENCES users(usu_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

-- 5. TABLA DE HISTORIAL (Para las gráficas de la Semana 3)
CREATE TABLE IF NOT EXISTS price_history (
    id_historial INTEGER PRIMARY KEY NOT NULL AUTOINCREMENT ,
    id_product INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_product) REFERENCES product(product_id) ON DELETE CASCADE
);

-- usuarios
INSERT INTO users (usu_mail, usu_password, usu_name, usu_rol) VALUES 
('admin@test.com', 'admin123', 'Administrador', 'admin'),
('user1@gmail.com', 'user123', 'Juan Pérez', 'user'),
('test_girl@hotmail.com', 'chica123', 'María García', 'user');