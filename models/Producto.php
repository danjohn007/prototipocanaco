<?php
require_once __DIR__ . '/../config/database.php';

class Producto {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $afiliacion_id;
    public $nombre;
    public $descripcion;
    public $imagen;
    public $fecha_registro;
    public $activo;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Create a new product
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET afiliacion_id=:afiliacion_id, nombre=:nombre, descripcion=:descripcion, imagen=:imagen";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // Bind values
        $stmt->bindParam(":afiliacion_id", $this->afiliacion_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":imagen", $this->imagen);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Get products by affiliation ID
     */
    public function getByAfiliacionId($afiliacion_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                WHERE afiliacion_id = :afiliacion_id AND activo = 1 
                ORDER BY fecha_registro DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':afiliacion_id', $afiliacion_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get product by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    /**
     * Delete product
     */
    public function delete($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    /**
     * Count products by affiliation
     */
    public function countByAfiliacion($afiliacion_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                WHERE afiliacion_id = :afiliacion_id AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':afiliacion_id', $afiliacion_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>