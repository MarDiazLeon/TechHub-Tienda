<?php
session_start();
require_once 'Clases/database.php';
require_once 'Clases/producto.php';
require_once 'Clases/carrito.php';


if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT id, nombre, precio FROM productos WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($p) {
        $cart = new carrito();
        $cart->agregar($p['id'], $p['nombre'], $p['precio']);
    }
}

// Redirigir de vuelta a la página principal 
header("Location: index.php");
exit();
?>