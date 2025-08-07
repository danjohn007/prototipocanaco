<?php
/**
 * SQLite Database Configuration (Fallback)
 * Chamber of Commerce CRM System
 */

class DatabaseSQLite {
    private $db_path;
    private $conn;

    public function __construct() {
        $this->db_path = __DIR__ . '/database.sqlite';
    }

    /**
     * Get database connection
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("sqlite:" . $this->db_path);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create tables if they don't exist
            $this->createTables();
            
        } catch(PDOException $exception) {
            error_log("SQLite connection error: " . $exception->getMessage());
        }

        return $this->conn;
    }

    /**
     * Create tables if they don't exist
     */
    private function createTables() {
        $sql = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            contraseña VARCHAR(255) NOT NULL,
            tipo_usuario VARCHAR(20) NOT NULL CHECK(tipo_usuario IN ('comerciante', 'validador', 'administrador')),
            fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
            activo BOOLEAN DEFAULT 1
        );

        CREATE TABLE IF NOT EXISTS sectores (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre VARCHAR(100) NOT NULL,
            descripcion TEXT,
            activo BOOLEAN DEFAULT 1
        );

        CREATE TABLE IF NOT EXISTS membresias (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre VARCHAR(100) NOT NULL,
            costo DECIMAL(10,2) NOT NULL,
            beneficios TEXT,
            descripcion TEXT,
            activo BOOLEAN DEFAULT 1
        );

        CREATE TABLE IF NOT EXISTS afiliaciones (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            empresa VARCHAR(200) NOT NULL,
            contacto VARCHAR(100) NOT NULL,
            telefono VARCHAR(20),
            direccion TEXT,
            sector_id INTEGER,
            membresia_id INTEGER,
            estatus VARCHAR(20) DEFAULT 'pendiente' CHECK(estatus IN ('pendiente', 'en_proceso', 'validada', 'rechazada')),
            fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
            fecha_validacion DATETIME NULL,
            validado_por INTEGER NULL,
            comentarios TEXT,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            FOREIGN KEY (sector_id) REFERENCES sectores(id),
            FOREIGN KEY (membresia_id) REFERENCES membresias(id),
            FOREIGN KEY (validado_por) REFERENCES usuarios(id)
        );

        CREATE TABLE IF NOT EXISTS productos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            afiliacion_id INTEGER,
            nombre VARCHAR(200) NOT NULL,
            descripcion TEXT,
            imagen VARCHAR(255),
            fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
            activo BOOLEAN DEFAULT 1,
            FOREIGN KEY (afiliacion_id) REFERENCES afiliaciones(id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            accion VARCHAR(255) NOT NULL,
            tabla_afectada VARCHAR(100),
            registro_id INTEGER,
            datos_anteriores TEXT,
            datos_nuevos TEXT,
            fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
            ip_address VARCHAR(45),
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        );
        ";
        
        $this->conn->exec($sql);
        
        // Insert default data if tables are empty
        $this->insertDefaultData();
    }

    /**
     * Insert default data
     */
    private function insertDefaultData() {
        // Check if sectores table has data
        $stmt = $this->conn->query("SELECT COUNT(*) FROM sectores");
        if ($stmt->fetchColumn() == 0) {
            $sql = "
            INSERT INTO sectores (nombre, descripcion) VALUES 
            ('Comercio', 'Empresas dedicadas al comercio y venta de productos'),
            ('Industria', 'Empresas manufactureras e industriales'),
            ('Turismo', 'Empresas del sector turístico y hotelero'),
            ('Servicios', 'Empresas de servicios profesionales y técnicos');
            ";
            $this->conn->exec($sql);
        }

        // Check if membresias table has data
        $stmt = $this->conn->query("SELECT COUNT(*) FROM membresias");
        if ($stmt->fetchColumn() == 0) {
            $sql = "
            INSERT INTO membresias (nombre, costo, beneficios, descripcion) VALUES 
            ('Básica', 1500.00, 'Acceso a eventos básicos, directorio de empresas', 'Membresía de entrada con beneficios esenciales'),
            ('Intermedia', 3000.00, 'Todos los beneficios básicos + capacitaciones, networking', 'Membresía intermedia con beneficios ampliados'),
            ('Premium', 5000.00, 'Todos los beneficios + consultoría, promoción preferencial', 'Membresía premium con beneficios completos'),
            ('Corporativa', 10000.00, 'Todos los beneficios + servicios exclusivos, representación', 'Membresía corporativa para grandes empresas');
            ";
            $this->conn->exec($sql);
        }

        // Check if usuarios table has data  
        $stmt = $this->conn->query("SELECT COUNT(*) FROM usuarios WHERE tipo_usuario IN ('administrador', 'validador')");
        if ($stmt->fetchColumn() == 0) {
            $sql = "
            INSERT INTO usuarios (nombre, email, contraseña, tipo_usuario) VALUES 
            ('Administrador General', 'admin@camaradecomercioqro.mx', '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador'),
            ('Validador Principal', 'validador@camaradecomercioqro.mx', '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'validador');
            ";
            $this->conn->exec($sql);
        }
    }
}
?>