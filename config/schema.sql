-- Database Schema for Chamber of Commerce CRM System
-- Execute this SQL to set up the database structure

-- Create database (if needed)
-- CREATE DATABASE camaradecomercio_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE camaradecomercio_crm;

-- Users table
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('comerciante', 'validador', 'administrador') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);

-- Sectors table
CREATE TABLE IF NOT EXISTS sectores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE
);

-- Memberships table
CREATE TABLE IF NOT EXISTS membresias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    costo DECIMAL(10,2) NOT NULL,
    beneficios TEXT,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE
);

-- Affiliations table
CREATE TABLE IF NOT EXISTS afiliaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    empresa VARCHAR(200) NOT NULL,
    contacto VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    sector_id INT,
    membresia_id INT,
    estatus ENUM('pendiente', 'en_proceso', 'validada', 'rechazada') DEFAULT 'pendiente',
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_validacion TIMESTAMP NULL,
    validado_por INT NULL,
    comentarios TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (sector_id) REFERENCES sectores(id),
    FOREIGN KEY (membresia_id) REFERENCES membresias(id),
    FOREIGN KEY (validado_por) REFERENCES usuarios(id)
);

-- Products table
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    afiliacion_id INT,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (afiliacion_id) REFERENCES afiliaciones(id) ON DELETE CASCADE
);

-- Activity logs table
CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    accion VARCHAR(255) NOT NULL,
    tabla_afectada VARCHAR(100),
    registro_id INT,
    datos_anteriores JSON,
    datos_nuevos JSON,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insert default data
INSERT INTO sectores (nombre, descripcion) VALUES 
('Comercio', 'Empresas dedicadas al comercio y venta de productos'),
('Industria', 'Empresas manufactureras e industriales'),
('Turismo', 'Empresas del sector turístico y hotelero'),
('Servicios', 'Empresas de servicios profesionales y técnicos');

INSERT INTO membresias (nombre, costo, beneficios, descripcion) VALUES 
('Básica', 1500.00, 'Acceso a eventos básicos, directorio de empresas', 'Membresía de entrada con beneficios esenciales'),
('Intermedia', 3000.00, 'Todos los beneficios básicos + capacitaciones, networking', 'Membresía intermedia con beneficios ampliados'),
('Premium', 5000.00, 'Todos los beneficios + consultoría, promoción preferencial', 'Membresía premium con beneficios completos'),
('Corporativa', 10000.00, 'Todos los beneficios + servicios exclusivos, representación', 'Membresía corporativa para grandes empresas');

-- Create default admin user (password: admin123)
INSERT INTO usuarios (nombre, email, contraseña, tipo_usuario) VALUES 
('Administrador General', 'admin@camaradecomercioqro.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador'),
('Validador Principal', 'validador@camaradecomercioqro.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'validador');