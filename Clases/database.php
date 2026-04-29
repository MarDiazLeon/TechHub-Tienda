<?php
class Database {
    private $host = "localhost";
    private $db_nombre = "techhub_db";
    private $db_username = "root";
    private $db_password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . 
            $this->db_nombre, $this->db_username, $this->db_password); 
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}       
?>            