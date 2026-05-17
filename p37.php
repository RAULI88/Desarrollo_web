<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Si ya hay una sesión activa, redirigir directamente a la sección exclusiva
if (isset($_SESSION['usuario_id'])) {
    header("Location: p37_dashboard.php");
    exit();
}

$mensaje_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (!empty($correo) && !empty($contrasena)) {
        // Configuración de la base de datos remota
        $host = 'sql3.freesqldatabase.com';
        $port = '3306';
        $dbname = 'sql3827221';
        $username = 'sql3827221';
        $password = 'yNi7K5WHLf';

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consultar si el correo existe en la tabla de la práctica 36
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar contraseña cifrada
            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                // Iniciar sesión con éxito
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombres'] = $usuario['nombres'];
                $_SESSION['usuario_apellidos'] = $usuario['apellidos'];
                $_SESSION['usuario_correo'] = $usuario['correo'];

                header("Location: p37_dashboard.php");
                exit();
            } else {
                $mensaje_error = "El correo electrónico o la contraseña son incorrectos.";
            }
        } catch (PDOException $e) {
            $mensaje_error = "Error de conexión con la base de datos.";
        }
    } else {
        $mensaje_error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 37 - Iniciar Sesión</title>
    <style>
        :root { --uas-blue: #002b5c; --uas-gold: #ffc72c; --bg: #f0f4f8; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); margin: 0; padding: 20px; color: #333; }
        .container { max-width: 450px; margin: 60px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: var(--uas-blue); border-bottom: 2px solid var(--uas-gold); padding-bottom: 10px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background: var(--uas-blue); color: white; border: none; padding: 12px; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { opacity: 0.9; }
        .error-box { background: #ffdddd; color: #d8000c; padding: 12px; border: 1px solid #d8000c; margin-bottom: 20px; border-radius: 5px; font-size: 14px; text-align: center; }
        .links { text-align: center; margin-top: 20px; font-size: 14px; }
        .links a { color: var(--uas-blue); text-decoration: none; font-weight: bold; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" style="color: var(--uas-blue); text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Volver al Menú</a>
    
    <h2>Control de Acceso</h2>

    <?php if (!empty($mensaje_error)): ?>
        <div class="error-box"><?= htmlspecialchars($mensaje_error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Correo Electrónico:</label>
            <input type="email" name="correo" required placeholder="ejemplo@correo.com">
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="contrasena" required placeholder="********">
        </div>
        <button type="submit">Ingresar al Sistema</button>
    </form>

    <div class="links">
        ¿No tienes una cuenta? <a href="p36.php">Regístrate aquí (P36)</a>
    </div>
</div>

</body>
</html>