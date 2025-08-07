<?php
require_once __DIR__ . '/../config/database.php';

class Sector {
    private $conn;
    private $table_name = "sectores";

    public $id;
    public $nombre;
    public $descripcion;
    public $activo;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Get all active sectors
     */
    public function getAll() {
        try {
            if ($this->conn === null) {
                error_log("Database connection is null in Sector::getAll()");
                return [];
            }
            
            $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1 ORDER BY nombre";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // If database query fails, return empty array to avoid breaking the form
            error_log("Error in Sector::getAll(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get sector by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }
}
?>