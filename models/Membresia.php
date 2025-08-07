<?php
require_once __DIR__ . '/../config/database.php';

class Membresia {
    private $conn;
    private $table_name = "membresias";

    public $id;
    public $nombre;
    public $costo;
    public $beneficios;
    public $descripcion;
    public $activo;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Get all active memberships
     */
    public function getAll() {
        try {
            if ($this->conn === null) {
                error_log("Database connection is null in Membresia::getAll()");
                return [];
            }
            
            $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1 ORDER BY costo";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                error_log("Failed to prepare query in Membresia::getAll(): " . implode(", ", $this->conn->errorInfo()));
                return [];
            }
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Failed to execute query in Membresia::getAll(): " . implode(", ", $stmt->errorInfo()));
                return [];
            }

            $memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Retrieved " . count($memberships) . " memberships from database");
            return $memberships;
            
        } catch (Exception $e) {
            // If database query fails, return empty array to avoid breaking the form
            error_log("Error in Membresia::getAll(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get membership by ID
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
     * Get membership statistics
     */
    public function getStats() {
        $query = "SELECT m.nombre, COUNT(a.id) as total
                FROM " . $this->table_name . " m
                LEFT JOIN afiliaciones a ON m.id = a.membresia_id
                WHERE m.activo = 1
                GROUP BY m.id, m.nombre
                ORDER BY m.costo";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>