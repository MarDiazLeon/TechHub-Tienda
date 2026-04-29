<?php
session_start();
require_once 'Clases/database.php';
require_once 'Clases/usuario.php';

$database = new Database();
$db = $database->getConnection();
$user = new usuario($db);

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->login($email, $password)) {
        $_SESSION['usuario_id'] = $user->id;
        $_SESSION['usuario_nombre'] = $user->nombre;
        header("Location: index.php");
        exit();
    } else {
        $error = "Lo sentimos.Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TechHub</title>
    <style>
     body { 
            background-color: #050505; 
            color: #0ff; 
            font-family: 'Courier New', monospace; 
            display: flex; justify-content: center; align-items: center; 
            height: 100vh; margin: 0; 
        }
        .card-login { 
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
        .btn-login { 
            width: 100%; background: transparent; color: #f0f; 
            border: 2px solid #f0f; padding: 12px; 
            font-weight: bold; cursor: pointer; text-transform: uppercase;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover { background: #f0f; color: #000; box-shadow: 0 0 20px #f0f; }
        
        
        .alerta { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.8rem; text-align: left; }
        .error { border: 1px solid #ff0055; color: #ff0055; background: rgba(255,0,85,0.1); }
        .exito { border: 1px solid #0f0; color: #0f0; background: rgba(0,255,0,0.1); border-left: 4px solid #0f0; }
        
        a { color: #0ff; text-decoration: none; font-size: 0.8rem; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card-login">
        <h2 style="color: #f0f; text-shadow: 0 0 10px #f0f;">Iniciar Sesion</h2>

        <?php if(isset($_GET['registro']) && $_GET['registro'] == 'exito'): ?>
            <div class="alerta exito" style="color: #0f0; border: 1px solid #0f0; padding: 10px; margin-bottom: 20px; font-family: 'Courier New', monospace; font-size: 0.8rem; background: rgba(0, 255, 0, 0.1);">
                > HEY! Eres uno de los nuestros!. Inicie sesión.
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-login">Acceder</button>
        </form>
        
        <div style="margin-top: 20px;">
            <a href="registro.php"> ¿Eres Nuevo? Crea una nueva cuenta aqui!</a>
        </div>
    </div>
</body>