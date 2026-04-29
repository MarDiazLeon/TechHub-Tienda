<?php
// iniciamos la sesión 
session_start();

require_once 'Clases/database.php';
require_once 'Clases/producto.php';
require_once 'Clases/carrito.php';

$database = new Database();
$db = $database->getConnection();

$producto = new Producto($db);
$stmt = $producto->LeerTodos();

// iniciamos el carrito para que esté listo para agregar productos
$mi_carrito = new carrito();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online - TechHub</title>
   <style>
   
    body { 
        font-family: 'Segoe UI', sans-serif; 
        background-color: #0d0221; 
        color: #fff;
        margin: 0; 
        padding: 0; 
    }

    header { 
        background-color: #000; 
        color: #0ff; 
        padding: 2rem; 
        text-align: center; 
        border-bottom: 4px solid #f0f;
        text-shadow: 0 0 10px #0ff;
    }

    .container { padding: 40px 20px; margin: 0 auto; max-width: 1200px; }

    .contenedor-productos {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 40px;
    }
    
    
    .card {
        background: #1a1a2e;
        border: 2px solid #f0f; 
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 10px 10px 0px #0ff; 
    }

    
    .card:hover {
        transform: translate(-5px, -5px);
        box-shadow: 15px 15px 0px #f0f; 
        border-color: #0ff;
    }

    .producto-img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: #000;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #333;
    }

    .card h3 { 
        color: #0ff; 
        font-size: 1.4rem; 
        margin: 10px 0; 
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .precio { 
        color: #fff; 
        background: #f0f; 
        font-size: 1.5rem; 
        font-weight: bold; 
        display: inline-block;
        padding: 5px 15px;
        margin: 10px 0;
        clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%); 
    }

    
    .btn-comprar {
        display: block;
        background-color: transparent;
        color: #0ff;
        padding: 12px;
        text-decoration: none;
        font-weight: bold;
        border: 2px solid #0ff;
        margin-top: auto;
        text-transform: uppercase;
        transition: all 0.2s;
    }

    .btn-comprar:hover {
        background-color: #0ff;
        color: #000;
        box-shadow: 0 0 20px #0ff; 
    }

    .btn-carrito-retro {
        background: rgba(0, 255, 255, 0.1); 
        border: 2px solid #0ff; 
        padding: 8px 20px;
        color: #0ff;
        text-decoration: none;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        margin-right: 20px;
        display: inline-block;
        transition: all 0.3s;
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.3), inset 0 0 10px rgba(0, 255, 255, 0.2);
    }
    
    .btn-carrito-retro:hover {
        background: #0ff;
        color: #000;
        box-shadow: 0 0 30px #0ff; 
        transform: scale(1.05);
    }

    .modal-retro {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0; top: 0; width: 100%; height: 100%; 
    background-color: rgba(0,0,0,0.9); 
}


.modal-contenido {
    background-color: #1a1a2e;
    margin: 15% auto;
    padding: 30px;
    border: 3px solid #0ff;
    width: 350px;
    text-align: center;
    box-shadow: 0 0 20px #0ff;
}


.btn-modal {
    background: transparent;
    border: 2px solid #0ff;
    color: #0ff;
    padding: 10px 15px;
    cursor: pointer;
    font-weight: bold;
    margin: 5px;
}

.btn-modal:hover {
    background: #0ff;
    color: #000;
}
</style>
        
</head>
<body>
    <header>
    <h1>TechHub - Tienda</h1>
    <div style="margin-top: 10px;">
        
        <a href="revisar_carrito.php" class="btn-carrito-retro">🛒 Ver Carrito </a>

        <?php if(isset($_SESSION['usuario_nombre'])): ?>
            <span>  ¡Hola! <strong style="color: #f0f; text-shadow: 0 0 5px #f0f;">
                <?php echo $_SESSION['usuario_nombre']; ?>
            </strong></span> | 
            <a href="logout.php" style="color: white; text-decoration: none;">Cerrar Sesión</a>

        <?php else: ?>
            <a href="login.php" style="color: white; text-decoration: none;">Iniciar Sesión</a> | 
            <a href="registro.php" style="color: white; text-decoration: none;">Registrarse</a>
        <?php endif; ?>
        
    </div>
</header>
    
    <div class="contenedor-productos">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="card">
            <img src="imagenes/<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>" class="producto-img">
            
            <h3><?php echo $row['nombre']; ?></h3>
            <p><?php echo $row['descripcion']; ?></p>
            <p class="precio">$<?php echo number_format($row['precio'], 0, ',', '.'); ?></p>
            
            <?php if(isset($_SESSION['usuario_nombre'])): ?>
                <a href="agregar_al_carrito.php?id=<?php echo $row['id']; ?>" class="btn-comprar">Agregar al carrito</a>
            <?php else: ?>
                <a href="javascript:void(0);" onclick="alertaLogin();" class="btn-comprar">Agregar al carrito</a>
            <?php endif; ?>
            </div>
    <?php endwhile; ?>
</div>
    </div>
    <script>
    function alertaLogin() {
        // En lugar de confirm(), mostramos nuestro modal
        document.getElementById("miModal").style.display = "block";
    }
    function cerrarModal() {
        document.getElementById("miModal").style.display = "none";
    }
    function irAlLogin() {
        window.location.href = "login.php";
    }

    window.onclick = function(event) {
        let modal = document.getElementById("miModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</script>
<div id="miModal" class="modal-retro">
    <div class="modal-contenido">
        <h2 style="color: #f0f; text-shadow: 0 0 10px #f0f;">[!] HEY! ACCESO REQUERIDO</h2>
        <p>Para que este producto sea tuyo, debes iniciar sesión!</p>
        <div style="margin-top: 20px;">
            <button onclick="irAlLogin()" class="btn-modal">INICIAR SESIÓN</button>
            <button onclick="cerrarModal()" class="btn-modal" style="border-color: #555; color: #555;">CANCELAR</button>
        </div>
    </div>
</div>
</body>
</html>