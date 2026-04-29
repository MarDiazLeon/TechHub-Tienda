<?php
class Producto {
    private $conn;
    private $table_name = "productos";
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function LeerTodos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>