<?php
/**
 * Database Configuration
 * Chamber of Commerce CRM System
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'camaradecomercio_crm';
    private $username = 'camaradecomercio_crm';
    private $password = 'Danjohn007';
    private $conn;

    /**
     * Get database connection
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Log the error instead of echoing it to avoid breaking redirects
            error_log("Database connection error: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>