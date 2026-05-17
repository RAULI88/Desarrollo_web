<?php
// --- 1. CONFIGURACIÓN DE LA BASE DE DATOS ---
$host = 'sql3.freesqldatabase.com';
$port = '3306';
$dbname = 'sql3827221';
$username = 'sql3827221';
$password = 'yNi7K5WHLf';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos. Verifica tus credenciales: " . $e->getMessage());
}

// --- 2. LÓGICA DEL CRUD ---
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$id_editar = isset($_GET['id']) ? $_GET['id'] : null;

// Variables para el formulario de edición
$edit_nombres = $edit_apellidos = $edit_correo = '';

// ELIMINAR (Delete)
if ($accion == 'eliminar' && $id_editar) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id_editar]);
    header("Location: p36.php");
    exit();
}

// OBTENER DATOS PARA EDITAR (Read un solo registro)
if ($accion == 'editar' && $id_editar) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id_editar]);
    $usuario_editar = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario_editar) {
        $edit_nombres = $usuario_editar['nombres'];
        $edit_apellidos = $usuario_editar['apellidos'];
        $edit_correo = $usuario_editar['correo'];
    }
}

// PROCESAR FORMULARIO (Create y Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    
    if (!empty($_POST['id'])) {
        // ACTUALIZAR (Update)
        $id_post = $_POST['id'];
        if (!empty($_POST['contrasena'])) {
            // Si escribió una nueva contraseña, la actualizamos cifrada
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET nombres=?, apellidos=?, correo=?, contrasena=? WHERE id=?");
            $stmt->execute([$nombres, $apellidos, $correo, $contrasena, $id_post]);
        } else {
            // Si dejó la contraseña en blanco, actualizamos el resto
            $stmt = $pdo->prepare("UPDATE usuarios SET nombres=?, apellidos=?, correo=? WHERE id=?");
            $stmt->execute([$nombres, $apellidos, $correo, $id_post]);
        }
    } else {
        // REGISTRAR (Create)
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Cifrado de seguridad
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombres, apellidos, correo, contrasena) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombres, $apellidos, $correo, $contrasena]);
    }
    header("Location: p36.php");
    exit();
}

// CONSULTAR TODOS LOS USUARIOS (Read)
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 36 - CRUD Usuarios</title>
    <style>
        :root { --uas-blue: #002b5c; --uas-gold: #ffc72c; --bg: #f0f4f8; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); margin: 0; padding: 20px; color: #333; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: var(--uas-blue); border-bottom: 2px solid var(--uas-gold); padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: var(--uas-blue); color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { opacity: 0.9; }
        .btn-cancel { background: #dc3545; text-decoration: none; padding: 8px 12px; border-radius: 4px; color: white; font-size: 14px; margin-left: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: var(--uas-blue); color: white; }
        tr:hover { background-color: #f5f5f5; }
        .acciones a { text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; font-weight: bold; }
        .btn-edit { background-color: var(--uas-gold); color: #333; }
        .btn-delete { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" style="color: var(--uas-blue); text-decoration: none; font-weight: bold;">&larr; Volver al Menú</a>
    
    <h2><?= $accion == 'editar' ? 'Modificar Usuario' : 'Registrar Nuevo Usuario' ?></h2>
    
    <form method="POST" action="p36.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id_editar) ?>">
        
        <div class="form-group">
            <label>Nombre(s):</label>
            <input type="text" name="nombres" required value="<?= htmlspecialchars($edit_nombres) ?>">
        </div>
        <div class="form-group">
            <label>Apellidos(s):</label>
            <input type="text" name="apellidos" required value="<?= htmlspecialchars($edit_apellidos) ?>">
        </div>
        <div class="form-group">
            <label>Correo Electrónico:</label>
            <input type="email" name="correo" required value="<?= htmlspecialchars($edit_correo) ?>">
        </div>
        <div class="form-group">
            <label>Contraseña <?= $accion == 'editar' ? '(Dejar en blanco para mantener la actual)' : '' ?>:</label>
            <input type="password" name="contrasena" <?= $accion == 'editar' ? '' : 'required' ?>>
        </div>
        
        <button type="submit"><?= $accion == 'editar' ? 'Guardar Cambios' : 'Registrar' ?></button>
        <?php if($accion == 'editar'): ?>
            <a href="p36.php" class="btn-cancel">Cancelar</a>
        <?php endif; ?>
    </form>

    <br>

    <h2>Usuarios Registrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre(s)</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['nombres']) ?></td>
                <td><?= htmlspecialchars($user['apellidos']) ?></td>
                <td><?= htmlspecialchars($user['correo']) ?></td>
                <td class="acciones">
                    <a href="p36.php?accion=editar&id=<?= $user['id'] ?>" class="btn-edit">Editar</a>
                    <a href="p36.php?accion=eliminar&id=<?= $user['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($usuarios)): ?>
            <tr>
                <td colspan="5" style="text-align: center;">No hay usuarios registrados aún.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>