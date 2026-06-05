<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- 1. CONFIGURACIÓN DE LA BASE DE DATOS (ENV) ---
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos.");
}

// --- 2. LÓGICA DE CERRAR SESIÓN ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: practica_final.php");
    exit();
}

$mensaje_error = '';
$mensaje_exito = '';

// --- 3. LÓGICA DE INICIO DE SESIÓN ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (!empty($correo) && !empty($contrasena)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
            header("Location: practica_final.php");
            exit();
        } else {
            $mensaje_error = "Correo o contraseña incorrectos.";
        }
    } else {
        $mensaje_error = "Por favor, completa los campos.";
    }
}

// --- 4. LÓGICA PARA GUARDAR EN LA BITÁCORA ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_bitacora']) && isset($_SESSION['usuario_id'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO bitacora 
            (nombre, carrera_grupo, tipo, descripcion, fecha_salida, hora_salida, firma_salida, fecha_entrega, hora_entrega, firma_entrega) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['nombre'],
            $_POST['carrera'] . ' / ' . $_POST['grupo'],
            $_POST['tipo'],
            $_POST['descripcion'],
            !empty($_POST['fecha_salida']) ? $_POST['fecha_salida'] : null,
            !empty($_POST['hora_salida']) ? $_POST['hora_salida'] : null,
            $_POST['firma_salida'],
            !empty($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : null,
            !empty($_POST['hora_entrega']) ? $_POST['hora_entrega'] : null,
            $_POST['firma_entrega']
        ]);
        
        $mensaje_exito = "¡Registro de préstamo guardado correctamente!";
    } catch (PDOException $e) {
        $mensaje_error = "Error al guardar el registro: " . $e->getMessage();
    }
}

// --- 5. OBTENER REGISTROS DE LA BITÁCORA ---
$registros_bitacora = [];
if (isset($_SESSION['usuario_id'])) {
    $stmt = $pdo->query("SELECT * FROM bitacora ORDER BY id DESC LIMIT 10");
    $registros_bitacora = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica Final - Sistema Integral FIM</title>
    <style>
        :root { 
            --uas-blue: #002b5c; 
            --uas-gold: #ffc72c; 
            --bg: #eef2f5; 
            --text: #333;
            --border: #ccd1d9;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg); margin: 0; padding: 20px; color: var(--text); }
        
        /* Contenedores Principales */
        .login-container { max-width: 400px; margin: 80px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 5px solid var(--uas-gold); }
        .app-container { max-width: 1200px; margin: 0 auto; background: white; padding: 0; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
        
        /* Encabezados Institucionales */
        .app-header { background-color: var(--uas-blue); color: white; padding: 20px 30px; text-align: center; border-bottom: 5px solid var(--uas-gold); position: relative; }
        .app-header h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
        .app-header h2 { margin: 5px 0 0 0; font-size: 16px; font-weight: normal; color: #e0e0e0; }
        .user-info { position: absolute; top: 20px; right: 30px; font-size: 14px; text-align: right; }
        .btn-logout { color: var(--uas-gold); text-decoration: none; font-weight: bold; font-size: 12px; border: 1px solid var(--uas-gold); padding: 4px 8px; border-radius: 4px; margin-top: 5px; display: inline-block; transition: 0.2s;}
        .btn-logout:hover { background: var(--uas-gold); color: var(--uas-blue); }

        /* Estilos del Formulario tipo Bitácora */
        .form-section { padding: 30px; }
        .bitacora-table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; }
        .bitacora-table th { background-color: #34495e; color: white; text-align: center; padding: 12px; font-size: 13px; text-transform: uppercase; border: 1px solid #2c3e50; }
        .bitacora-table td { border: 1px solid var(--border); padding: 10px; vertical-align: top; }
        
        /* Inputs mejorados */
        input[type="text"], input[type="date"], input[type="time"], select { width: 100%; padding: 8px; margin-top: 6px; border: 1px solid #bbb; border-radius: 4px; box-sizing: border-box; font-family: inherit; font-size: 13px; transition: border 0.3s; }
        input[type="text"]:focus, input[type="date"]:focus, select:focus { border-color: var(--uas-blue); outline: none; box-shadow: 0 0 5px rgba(0, 43, 92, 0.2); }
        .radio-group { display: flex; gap: 15px; margin-top: 10px; font-size: 14px; }
        .radio-group label { display: flex; align-items: center; gap: 5px; cursor: pointer; }
        
        /* Botones */
        .btn-container { text-align: right; margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; }
        button { padding: 10px 24px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 14px; transition: 0.3s; }
        .btn-primary { background-color: var(--uas-blue); color: white; }
        .btn-primary:hover { background-color: #001f42; }
        .btn-secondary { background-color: #e9ecef; color: #333; margin-right: 10px; }
        .btn-secondary:hover { background-color: #d3d9df; }
        .btn-login { width: 100%; background: var(--uas-blue); color: white; padding: 12px; margin-top: 15px; }

        /* Alertas */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; font-weight: bold; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* Tabla de Historial */
        .history-section { padding: 0 30px 30px 30px; }
        .history-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .history-table th { background-color: #f8f9fa; color: var(--uas-blue); padding: 10px; border-bottom: 2px solid var(--border); text-align: left; }
        .history-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .history-table tr:hover { background-color: #f1f4f8; }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['usuario_id'])): ?>
    <div class="login-container">
        <a href="index.php" style="color: var(--uas-blue); text-decoration: none; font-weight: bold; font-size: 14px; display: block; margin-bottom: 15px;">&larr; Volver al Menú</a>
        <h2 style="color: var(--uas-blue); text-align: center; margin-top: 0;">SISTEMA FIM</h2>
        <p style="text-align: center; color: #666; font-size: 14px; margin-bottom: 20px;">Inicia sesión para acceder a la bitácora</p>
        
        <?php if (!empty($mensaje_error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($mensaje_error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label style="font-size: 14px; font-weight: bold;">Correo Electrónico:</label>
            <input type="text" name="correo" required placeholder="ejemplo@correo.com">
            
            <label style="font-size: 14px; font-weight: bold; margin-top: 15px; display: block;">Contraseña:</label>
            <input type="password" name="contrasena" required placeholder="********" style="width: 100%; padding: 8px; margin-top: 6px; border: 1px solid #bbb; border-radius: 4px; box-sizing: border-box;">
            
            <button type="submit" name="login_submit" class="btn-primary btn-login">Ingresar al Sistema</button>
        </form>
    </div>

<?php else: ?>
    <div class="app-container">
        <div class="app-header">
            <h1>Facultad de Ingeniería Mochis</h1>
            <h2>Coordinación de Centros de Cómputo y Red Escolar</h2>
            <div class="user-info">
                Operador: <strong><?= htmlspecialchars($_SESSION['usuario_nombre']) ?></strong><br>
                <a href="?logout=1" class="btn-logout">Cerrar Sesión</a>
            </div>
        </div>

        <div class="form-section">
            <h3 style="color: var(--uas-blue); border-bottom: 2px solid var(--border); padding-bottom: 8px; margin-top: 0;">NUEVO REGISTRO DE PRÉSTAMO DE EQUIPO</h3>
            
            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($mensaje_exito) ?></div>
            <?php endif; ?>
            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($mensaje_error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <table class="bitacora-table">
                    <tr>
                        <th width="20%">Datos del Usuario</th>
                        <th width="15%">Carrera / Grupo</th>
                        <th width="12%">Tipo</th>
                        <th width="19%">Equipo Solicitado</th>
                        <th width="17%">Registro de Salida</th>
                        <th width="17%">Registro de Entrega</th>
                    </tr>
                    <tr>
                        <td>
                            <label style="font-size: 12px; font-weight:bold;">Nombre Completo:</label>
                            <input type="text" name="nombre" required placeholder="Ej. Juan Pérez">
                        </td>
                        <td>
                            <label style="font-size: 12px; font-weight:bold;">Carrera:</label>
                            <select name="carrera">
                                <option value="Software">Software</option>
                                <option value="Civil">Civil</option>
                                <option value="Procesos">Procesos</option>
                            </select>
                            <label style="font-size: 12px; font-weight:bold; display:block; margin-top:8px;">Grupo:</label>
                            <input type="text" name="grupo" placeholder="Ej. 3-1">
                        </td>
                        <td>
                            <div class="radio-group" style="flex-direction: column;">
                                <label><input type="radio" name="tipo" value="Alumno" checked> Alumno</label>
                                <label><input type="radio" name="tipo" value="Profesor"> Profesor</label>
                            </div>
                        </td>
                        <td>
                            <label style="font-size: 12px; font-weight:bold;">Descripción del Equipo:</label>
                            <input type="text" name="descripcion" required placeholder="Ej. Laptop HP #05">
                        </td>
                        <td>
                            <input type="date" name="fecha_salida" required>
                            <input type="time" name="hora_salida" required>
                            <input type="text" name="firma_salida" placeholder="Firma de quien recibe">
                        </td>
                        <td>
                            <input type="date" name="fecha_entrega">
                            <input type="time" name="hora_entrega">
                            <input type="text" name="firma_entrega" placeholder="Firma de quien entrega">
                        </td>
                    </tr>
                </table>

                <div class="btn-container">
                    <button type="reset" class="btn-secondary">Limpiar Campos</button>
                    <button type="submit" name="guardar_bitacora" class="btn-primary">Guardar Registro en Bitácora</button>
                </div>
            </form>
        </div>

        <div class="history-section">
            <h3 style="color: var(--uas-blue); border-bottom: 2px solid var(--border); padding-bottom: 8px;">ÚLTIMOS PRÉSTAMOS REGISTRADOS</h3>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Tipo</th>
                        <th>Equipo</th>
                        <th>Fecha Salida</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros_bitacora)): ?>
                        <tr><td colspan="6" style="text-align: center; color: #777;">No hay registros recientes.</td></tr>
                    <?php else: ?>
                        <?php foreach ($registros_bitacora as $reg): ?>
                            <tr>
                                <td>#<?= $reg['id'] ?></td>
                                <td><strong><?= htmlspecialchars($reg['nombre']) ?></strong><br><span style="color:#777; font-size:11px;"><?= htmlspecialchars($reg['carrera_grupo']) ?></span></td>
                                <td><?= htmlspecialchars($reg['tipo']) ?></td>
                                <td><?= htmlspecialchars($reg['descripcion']) ?></td>
                                <td><?= htmlspecialchars($reg['fecha_salida']) ?> <?= htmlspecialchars($reg['hora_salida']) ?></td>
                                <td>
                                    <?php if ($reg['fecha_entrega']): ?>
                                        <span style="color: green; font-weight: bold;">✓ Entregado</span>
                                    <?php else: ?>
                                        <span style="color: #d35400; font-weight: bold;">En uso</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</body>
</html>