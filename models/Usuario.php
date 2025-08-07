<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $email;
    public $contraseña;
    public $tipo_usuario;
    public $fecha_registro;
    public $activo;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Create a new user
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET nombre=:nombre, email=:email, contraseña=:contraseña, tipo_usuario=:tipo_usuario";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->tipo_usuario = htmlspecialchars(strip_tags($this->tipo_usuario));

        // Hash password
        $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);

        // Bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":contraseña", $this->contraseña);
        $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Login user
     */
    public function login($email, $password) {
        $query = "SELECT id, nombre, email, contraseña, tipo_usuario 
                FROM " . $this->table_name . " 
                WHERE email = :email AND activo = 1 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $num = $stmt->rowCount();

        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($password, $row['contraseña'])) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->email = $row['email'];
                $this->tipo_usuario = $row['tipo_usuario'];
                return true;
            }
        }

        return false;
    }

    /**
     * Get user by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->email = $row['email'];
            $this->tipo_usuario = $row['tipo_usuario'];
            $this->fecha_registro = $row['fecha_registro'];
            $this->activo = $row['activo'];
            return true;
        }

        return false;
    }

    /**
     * Check if email exists
     */
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Get all users
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>