<?php
session_start();
require_once 'Clases/database.php';
require_once 'Clases/orden.php';
require_once 'Clases/carrito.php';

// Si no está logueado, lo mandamos al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$cart = new carrito();
$productos = $cart->obtenerProductos();

if (empty($productos)) {
    header("Location: index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$orden = new orden($db);

// se crea la orden con el usuario logueado
if ($orden->crearOrden($_SESSION['usuario_id'], $cart->calcularTotal(), $productos)) {
    $cart->vaciar(); // Limpiamos el carrito tras la compra
    echo "<script>alert('¡Compra exitosa! Disfruta de tu compra.'); window::location='index.php';</script>";
} else {
    echo "Lo sentimos! Hubo un error en procesar tu pedido. Por favor, inténtalo de nuevo.";
}
?>