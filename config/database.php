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

        // Try MySQL first
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Test the connection
            $this->conn->query("SELECT 1");
            
        } catch(PDOException $exception) {
            // Log the MySQL error and try SQLite fallback
            error_log("MySQL connection error: " . $exception->getMessage());
            error_log("Falling back to SQLite database");
            
            try {
                require_once __DIR__ . '/database_sqlite.php';
                $sqlite_db = new DatabaseSQLite();
                $this->conn = $sqlite_db->getConnection();
            } catch(Exception $e) {
                error_log("SQLite fallback failed: " . $e->getMessage());
            }
        }

        return $this->conn;
    }
}
?>