<?php
class orden {
    private $conn;
    private $table_ordenes = "ordenes";
    private $table_detalle = "detalle_orden";

    public function __construct($db) {
        $this->conn = $db;
    }

    //para crear una orden y sus detalles
    public function crearOrden($usuario_id, $total, $carrito) {
        $query_orden = "INSERT INTO " . $this->table_ordenes . " (usuario_id, total) VALUES (:usuario_id, :total)";
        $stmt = $this->conn->prepare($query_orden);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':total', $total);

        if ($stmt->execute()) {
            $orden_id = $this->conn->lastInsertId(); //obtener el ID de la orden recién creada
            foreach ($carrito as $item) { //recorrer el carrito para insertar cada producto en detalle_orden
                $query_detalle = "INSERT INTO " . $this->table_detalle . " (orden_id, producto_id, cantidad, precio) 
                      VALUES (:orden_id, :producto_id, :cantidad, :precio_unitario)";
                $stmt_detalle = $this->conn->prepare($query_detalle);
                $stmt_detalle->bindParam(':orden_id', $orden_id);
                $stmt_detalle->bindParam(':producto_id', $item['id']);
                $stmt_detalle->bindParam(':cantidad', $item['cantidad']);
                $stmt_detalle->bindParam(':precio_unitario', $item['precio']);
                $stmt_detalle->execute();
            }
            return true;
        }
        return false;
    }
}
?>