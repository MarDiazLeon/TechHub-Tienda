<?php
class usuario {
    private $conn;
    private $table_name = "usuarios";
    public $id;
    public $nombre;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // para registrar un nuevo usuario
    public function registrar() {
    try {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, password) VALUES (:nombre, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Encriptar la contraseña 
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;

    } catch (PDOException $e) {
        // Este bloque atrapa el error de "Email duplicado"
        return false;
    }
}
    // para iniciar sesión
    public function login($email, $password) {
        $query = "SELECT id, nombre, email, password FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { // si se encuentra el usuario
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // verificar la contraseña
            if (password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                return true; // retornar true si la contraseña es correcta
            }
        }
        return false;
    }
}
?>