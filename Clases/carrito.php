<?php
class  carrito {
    public function __construct() {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    }
    public function agregar($id, $nombre, $precio, $cantidad = 1) {
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$id] = array(
                'id' => $id,
                'nombre'=> $nombre,
                'precio' => $precio,
                'cantidad' => $cantidad
            );
        }
    }
    public function obtenerProductos() {
        return $_SESSION['carrito'];
    }
    public function calcularTotal() { //calcular el total del carrito
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }
    // vaciar el carrito
    public function vaciar() {
        $_SESSION['carrito'] = array();
    }
}
?>