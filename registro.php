<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'Clases/database.php';
require_once 'Clases/usuario.php';

$database = new Database();
$db = $database->getConnection();
$user = new usuario($db);

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->nombre = trim($_POST['nombre']);
    $user->email = trim($_POST['email']);
    $user->password = $_POST['password'];

    if ($user->registrar()) {
        // Redirigimos al login con un mensaje de éxito
        header("Location: login.php?registro=exito");
        exit();
    } else {
        $mensaje = "<div class='alerta error'>[!] ERROR: El correo ya existe!!.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - TechHub</title>
    <style>
       body { 
            background-color: #050505; 
            color: #0ff; 
            font-family: 'Courier New', monospace; 
            display: flex; justify-content: center; align-items: center; 
            height: 100vh; margin: 0; 
        }
        .card-registro { 
            background: #111; 
            padding: 2rem; 
            border: 2px solid #0ff; 
            box-shadow: 0 0 20px #0ff; 
            width: 100%; max-width: 350px; 
            text-align: center;
        }
        input { 
            width: 100%; padding: 12px; margin: 10px 0; 
            background: #222; border: 1px solid #f0f; 
            color: #fff; border-radius: 4px; box-sizing: border-box; 
        }
        input:focus { outline: none; border-color: #0ff; box-shadow: 0 0 10px #0ff; }
        .btn-reg { 
            width: 100%; background: transparent; color: #f0f; 
            border: 2px solid #f0f; padding: 12px; 
            font-weight: bold; cursor: pointer; text-transform: uppercase;
            transition: 0.3s;
        }
        .btn-reg:hover { background: #f0f; color: #000; box-shadow: 0 0 20px #f0f; }
        .alerta { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.8rem; }
        .error { border: 1px solid #ff0055; color: #ff0055; background: rgba(255,0,85,0.1); }
        a { color: #0ff; text-decoration: none; font-size: 0.8rem; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card-registro">
        <h2 style="color: #f0f; text-shadow: 0 0 10px #f0f;">> Crear Cuenta</h2>
        <?php echo $mensaje; ?>
        <form method="POST" action="registro.php">
            <input type="text" name="nombre" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-reg">Registrarme</button>
        </form>
        <div style="margin-top: 20px;">
            <a href="login.php"> Volver al Login</a>
        </div>
    </div>
</body>
</html>