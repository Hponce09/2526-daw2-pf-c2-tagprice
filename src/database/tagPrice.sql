CREATE DATABASE IF NOT EXISTS anti_inflacion;
USE anti_inflacion;

-- 1. TABLA DE USUARIOS
CREATE TABLE IF NOT EXISTS users (
    usu_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_mail VARCHAR(50) NOT NULL UNIQUE,
    usu_password VARCHAR(255) NOT NULL,
    usu_name VARCHAR(200) NOT NULL,
    usu_rol VARCHAR(20) NOT NULL DEFAULT 'user'
);

-- 2. TABLA DE PRODUCTOS (Info general)
CREATE TABLE IF NOT EXISTS product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    imagen TEXT, 
    url_compra TEXT NOT NULL, 
    precio_actual DECIMAL(10,2) NOT NULL
);

-- 3. TABLA INTERMEDIA DE FAVORITOS (Relación N:M)
CREATE TABLE IF NOT EXISTS favorites (
    favoritos_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_id INT NOT NULL,
    product_id INT NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usu_id) REFERENCES users(usu_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

-- 4. TABLA DE HISTORIAL (Para la gráfica)
CREATE TABLE IF NOT EXISTS price_history (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_product INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha_registro DATE DEFAULT (CURRENT_DATE), -- Usamos DATE para que solo haya un registro por día
    FOREIGN KEY (id_product) REFERENCES product(product_id) ON DELETE CASCADE
);

-- Insertar datos de prueba
INSERT INTO users (usu_mail, usu_password, usu_name, usu_rol) VALUES 
('admin@test.com', 'admin123', 'Administrador', 'admin'),
('user1@gmail.com', 'user123', 'Juan Pérez', 'user'),
('test_girl@hotmail.com', 'chica123', 'María García', 'user');