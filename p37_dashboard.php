<?php
session_start();

// Control estricto de acceso: Si no existe la variable de sesión, denegar entrada
if (!isset($_SESSION['usuario_id'])) {
    header("Location: p37.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 37 - Área Exclusiva</title>
    <style>
        :root { --uas-blue: #002b5c; --uas-gold: #ffc72c; --bg: #f0f4f8; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 700px; margin: 50px auto; background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: var(--uas-blue); }
        .welcome-box { background: #e6f0fa; border-left: 5px solid var(--uas-blue); padding: 15px; margin: 20px 0; text-align: left; border-radius: 0 5px 5px 0; }
        .btn-logout { display: inline-block; background: #dc3545; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; margin-top: 20px; }
        .btn-logout:hover { opacity: 0.9; }
    </style>
</head>
<body>

<div class="container">
    <h1>🔓 Sección Exclusiva del Sistema</h1>
    <p>Has iniciado sesión correctamente. Esta pantalla es únicamente visible para usuarios autenticados.</p>

    <div class="welcome-box">
        <strong>Datos del Usuario Firmado:</strong><br>
        • <strong>Nombre completo:</strong> <?= htmlspecialchars($_SESSION['usuario_nombres'] . ' ' . $_SESSION['usuario_apellidos']) ?><br>
        • <strong>Correo Electrónico:</strong> <?= htmlspecialchars($_SESSION['usuario_correo']) ?><br>
        • <strong>ID de Sesión Seguro:</strong> <code><?= htmlspecialchars(session_id()) ?></code>
    </div>

    <a href="p37_logout.php" class="btn-logout">Cerrar Sesión Segura</a>
</div>

</body>
</html>