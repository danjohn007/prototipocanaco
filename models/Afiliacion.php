<?php
require_once __DIR__ . '/../config/database.php';

class Afiliacion {
    private $conn;
    private $table_name = "afiliaciones";

    public $id;
    public $usuario_id;
    public $empresa;
    public $contacto;
    public $telefono;
    public $direccion;
    public $sector_id;
    public $membresia_id;
    public $estatus;
    public $fecha_solicitud;
    public $fecha_validacion;
    public $validado_por;
    public $comentarios;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Create a new affiliation
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET usuario_id=:usuario_id, empresa=:empresa, contacto=:contacto, 
                    telefono=:telefono, direccion=:direccion, sector_id=:sector_id, 
                    membresia_id=:membresia_id";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->empresa = htmlspecialchars(strip_tags($this->empresa));
        $this->contacto = htmlspecialchars(strip_tags($this->contacto));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));

        // Bind values
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":empresa", $this->empresa);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":sector_id", $this->sector_id);
        $stmt->bindParam(":membresia_id", $this->membresia_id);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Get affiliation by ID
     */
    public function getById($id) {
        $query = "SELECT a.*, s.nombre as sector_nombre, m.nombre as membresia_nombre, 
                         u.nombre as usuario_nombre, u.email as usuario_email
                FROM " . $this->table_name . " a
                LEFT JOIN sectores s ON a.sector_id = s.id
                LEFT JOIN membresias m ON a.membresia_id = m.id
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.id = :id LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all affiliations with filters
     */
    public function getAll($estatus = null, $sector_id = null, $limit = null) {
        $query = "SELECT a.*, s.nombre as sector_nombre, m.nombre as membresia_nombre, 
                         u.nombre as usuario_nombre, u.email as usuario_email
                FROM " . $this->table_name . " a
                LEFT JOIN sectores s ON a.sector_id = s.id
                LEFT JOIN membresias m ON a.membresia_id = m.id
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE 1=1";

        if ($estatus) {
            $query .= " AND a.estatus = :estatus";
        }
        if ($sector_id) {
            $query .= " AND a.sector_id = :sector_id";
        }

        $query .= " ORDER BY a.fecha_solicitud DESC";

        if ($limit) {
            $query .= " LIMIT " . intval($limit);
        }

        $stmt = $this->conn->prepare($query);

        if ($estatus) {
            $stmt->bindParam(':estatus', $estatus);
        }
        if ($sector_id) {
            $stmt->bindParam(':sector_id', $sector_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update affiliation status
     */
    public function updateStatus($id, $estatus, $validado_por = null, $comentarios = null) {
        $query = "UPDATE " . $this->table_name . " 
                SET estatus = :estatus, fecha_validacion = NOW()";

        if ($validado_por) {
            $query .= ", validado_por = :validado_por";
        }
        if ($comentarios) {
            $query .= ", comentarios = :comentarios";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estatus', $estatus);
        $stmt->bindParam(':id', $id);

        if ($validado_por) {
            $stmt->bindParam(':validado_por', $validado_por);
        }
        if ($comentarios) {
            $stmt->bindParam(':comentarios', $comentarios);
        }

        return $stmt->execute();
    }

    /**
     * Get statistics by sector
     */
    public function getStatsBySector() {
        $query = "SELECT s.nombre, COUNT(a.id) as total
                FROM sectores s
                LEFT JOIN " . $this->table_name . " a ON s.id = a.sector_id
                GROUP BY s.id, s.nombre
                ORDER BY s.nombre";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get statistics by status
     */
    public function getStatsByStatus() {
        $query = "SELECT estatus, COUNT(*) as total
                FROM " . $this->table_name . "
                GROUP BY estatus";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get affiliation by user ID
     */
    public function getByUserId($usuario_id) {
        $query = "SELECT a.*, s.nombre as sector_nombre, m.nombre as membresia_nombre
                FROM " . $this->table_name . " a
                LEFT JOIN sectores s ON a.sector_id = s.id
                LEFT JOIN membresias m ON a.membresia_id = m.id
                WHERE a.usuario_id = :usuario_id
                ORDER BY a.fecha_solicitud DESC
                LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>