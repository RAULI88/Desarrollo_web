<?php
require_once 'db_config.php';
error_reporting(E_ALL); ini_set('display_errors', 1);
$pdo = getDB();

$accion = $_GET['accion'] ?? '';
$id     = $_GET['id'] ?? '';
$msg    = '';

// ENTREGAR EQUIPO
if ($accion === 'entregar' && $id) {
    $stmt = $pdo->prepare("SELECT id_equipo FROM prestamos WHERE id=? AND estado='activo'");
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($p) {
        $pdo->prepare("UPDATE prestamos SET estado='entregado', fecha_entrega=CURDATE(), hora_entrega=CURTIME() WHERE id=?")->execute([$id]);
        $pdo->prepare("UPDATE equipos SET cantidad_disponible=cantidad_disponible+1 WHERE id=?")->execute([$p['id_equipo']]);
    }
    header("Location: pf_prestamos.php"); exit();
}

// ELIMINAR
if ($accion === 'eliminar' && $id) {
    $stmt = $pdo->prepare("SELECT id_equipo, estado FROM prestamos WHERE id=?");
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($p && $p['estado'] === 'activo') {
        $pdo->prepare("UPDATE equipos SET cantidad_disponible=cantidad_disponible+1 WHERE id=?")->execute([$p['id_equipo']]);
    }
    $pdo->prepare("DELETE FROM prestamos WHERE id=?")->execute([$id]);
    header("Location: pf_prestamos.php"); exit();
}

// REGISTRAR PRÉSTAMO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario   = $_POST['id_usuario'];
    $id_equipo    = $_POST['id_equipo'];
    $id_carrera   = $_POST['id_carrera'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $grupo        = trim($_POST['grupo']);
    $obs          = trim($_POST['observaciones']);

    // Verificar disponibilidad
    $eq = $pdo->prepare("SELECT cantidad_disponible FROM equipos WHERE id=?");
    $eq->execute([$id_equipo]);
    $equipo = $eq->fetch(PDO::FETCH_ASSOC);

    if ($equipo && $equipo['cantidad_disponible'] > 0) {
        $pdo->prepare("INSERT INTO prestamos (id_usuario,id_equipo,id_carrera,tipo_usuario,grupo,hora_prestamo,fecha_prestamo,estado,observaciones) VALUES (?,?,?,?,?,CURTIME(),CURDATE(),'activo',?)")
            ->execute([$id_usuario,$id_equipo,$id_carrera,$tipo_usuario,$grupo,$obs]);
        $pdo->prepare("UPDATE equipos SET cantidad_disponible=cantidad_disponible-1 WHERE id=?")->execute([$id_equipo]);
        header("Location: pf_prestamos.php"); exit();
    } else {
        $msg = "⚠️ No hay unidades disponibles de ese equipo.";
    }
}

// DATOS PARA FORMULARIO
$usuarios  = $pdo->query("SELECT id, CONCAT(nombres,' ',apellidos) AS nombre FROM usuarios ORDER BY nombres")->fetchAll(PDO::FETCH_ASSOC);
$equipos   = $pdo->query("SELECT * FROM equipos WHERE cantidad_disponible>0 ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$carreras  = $pdo->query("SELECT c.*, u.nombre AS unidad FROM carreras c JOIN unidades_academicas u ON c.id_unidad=u.id ORDER BY c.nombre")->fetchAll(PDO::FETCH_ASSOC);

// LISTADO DE PRÉSTAMOS ACTIVOS + RECIENTES
$lista = $pdo->query("
    SELECT p.*, 
           CONCAT(u.nombres,' ',u.apellidos) AS usuario_nombre,
           e.nombre AS equipo_nombre,
           c.nombre AS carrera_nombre
    FROM prestamos p
    JOIN usuarios u ON p.id_usuario=u.id
    JOIN equipos e ON p.id_equipo=e.id
    JOIN carreras c ON p.id_carrera=c.id
    ORDER BY p.estado ASC, p.fecha_prestamo DESC, p.hora_prestamo DESC
    LIMIT 50
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Préstamos</title>
<?php include 'pf_style.php'; ?>
</head><body>
<div class="pf-header">
    <a href="index.php" class="pf-back">← Menú</a>
    <h1>📋 Préstamo de Equipos</h1>
</div>
<div class="pf-container">
  <div class="pf-form-card">
    <h2>Registrar Nuevo Préstamo</h2>
    <?php if($msg): ?><div class="pf-alert"><?= $msg ?></div><?php endif; ?>
    <form method="POST">
      <div class="pf-field"><label>Usuario (Alumno/Profesor)</label>
        <select name="id_usuario" required>
          <option value="">-- Selecciona usuario --</option>
          <?php foreach($usuarios as $u): ?>
          <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="pf-row">
        <div class="pf-field"><label>Tipo</label>
          <select name="tipo_usuario" required>
            <option value="alumno">Alumno</option>
            <option value="profesor">Profesor</option>
          </select></div>
        <div class="pf-field"><label>Grupo</label>
          <input type="text" name="grupo" placeholder="Ej. 3-A"></div>
      </div>
      <div class="pf-field"><label>Carrera</label>
        <select name="id_carrera" required>
          <option value="">-- Selecciona carrera --</option>
          <?php foreach($carreras as $c): ?>
          <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?> (<?= htmlspecialchars($c['unidad']) ?>)</option>
          <?php endforeach; ?>
        </select></div>
      <div class="pf-field"><label>Equipo a Prestar</label>
        <select name="id_equipo" required>
          <option value="">-- Selecciona equipo --</option>
          <?php foreach($equipos as $e): ?>
          <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?> (<?= $e['cantidad_disponible'] ?> disponibles)</option>
          <?php endforeach; ?>
        </select></div>
      <div class="pf-field"><label>Observaciones</label>
        <input type="text" name="observaciones" placeholder="Notas adicionales..."></div>
      <div class="pf-actions">
        <button type="submit" class="btn-primary">📤 Registrar Préstamo</button>
      </div>
    </form>
  </div>

  <div class="pf-table-card">
    <h2>Préstamos Recientes</h2>
    <table class="pf-table">
      <thead><tr><th>#</th><th>Usuario</th><th>Equipo</th><th>Carrera</th><th>Tipo</th><th>Grupo</th><th>Fecha/Hora</th><th>Estado</th><th>Acciones</th></tr></thead>
      <tbody>
        <?php foreach($lista as $r): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['usuario_nombre']) ?></td>
          <td><?= htmlspecialchars($r['equipo_nombre']) ?></td>
          <td><?= htmlspecialchars($r['carrera_nombre']) ?></td>
          <td><?= ucfirst($r['tipo_usuario']) ?></td>
          <td><?= htmlspecialchars($r['grupo']) ?></td>
          <td><?= $r['fecha_prestamo'] ?> <?= $r['hora_prestamo'] ?></td>
          <td><span class="pf-badge <?= $r['estado']==='activo'?'badge-warn':($r['estado']==='entregado'?'badge-ok':'badge-no') ?>"><?= ucfirst($r['estado']) ?></span></td>
          <td class="pf-btns">
            <?php if($r['estado']==='activo'): ?>
            <a href="?accion=entregar&id=<?= $r['id'] ?>" class="btn-edit" onclick="return confirm('¿Marcar como entregado?')">✅ Entregar</a>
            <?php endif; ?>
            <a href="?accion=eliminar&id=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar este préstamo?')">🗑️</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($lista)): ?><tr><td colspan="9" class="pf-empty">Sin préstamos</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>