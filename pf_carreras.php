<?php
require_once 'db_config.php';
error_reporting(E_ALL); ini_set('display_errors', 1);
$pdo = getDB();
 
$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? '';
$edit = ['nombre'=>'','clave'=>'','id_unidad'=>''];
 
if ($accion === 'eliminar' && $id) {
    $pdo->prepare("DELETE FROM carreras WHERE id=?")->execute([$id]);
    header("Location: pf_carreras.php"); exit();
}
if ($accion === 'editar' && $id) {
    $row = $pdo->prepare("SELECT * FROM carreras WHERE id=?");
    $row->execute([$id]);
    $edit = $row->fetch(PDO::FETCH_ASSOC) ?: $edit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $clave  = trim($_POST['clave']);
    $id_u   = $_POST['id_unidad'];
    if (!empty($_POST['id'])) {
        $pdo->prepare("UPDATE carreras SET nombre=?,clave=?,id_unidad=? WHERE id=?")->execute([$nombre,$clave,$id_u,$_POST['id']]);
    } else {
        $pdo->prepare("INSERT INTO carreras (nombre,clave,id_unidad) VALUES (?,?,?)")->execute([$nombre,$clave,$id_u]);
    }
    header("Location: pf_carreras.php"); exit();
}
$lista = $pdo->query("SELECT c.*,u.nombre AS unidad FROM carreras c JOIN unidades_academicas u ON c.id_unidad=u.id ORDER BY c.nombre")->fetchAll(PDO::FETCH_ASSOC);
$unidades = $pdo->query("SELECT * FROM unidades_academicas ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Carreras</title>
<?php include 'pf_style.php'; ?>
</head><body>
<div class="pf-header">
    <a href="index.php" class="pf-back">← Menú</a>
    <h1>🎓 Carreras</h1>
</div>
<div class="pf-container">
  <div class="pf-form-card">
    <h2><?= $accion==='editar' ? 'Editar' : 'Nueva' ?> Carrera</h2>
    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? '') ?>">
      <div class="pf-field"><label>Unidad Académica</label>
        <select name="id_unidad" required>
          <option value="">-- Selecciona --</option>
          <?php foreach($unidades as $u): ?>
          <option value="<?= $u['id'] ?>" <?= ($edit['id_unidad']==$u['id'])?'selected':'' ?>><?= htmlspecialchars($u['nombre']) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="pf-field"><label>Nombre de la Carrera</label>
        <input type="text" name="nombre" required value="<?= htmlspecialchars($edit['nombre']) ?>" placeholder="Ej. Ingeniería en Software"></div>
      <div class="pf-field"><label>Clave</label>
        <input type="text" name="clave" value="<?= htmlspecialchars($edit['clave']) ?>" placeholder="Ej. IS"></div>
      <div class="pf-actions">
        <button type="submit" class="btn-primary"><?= $accion==='editar' ? 'Guardar Cambios' : 'Agregar' ?></button>
        <?php if($accion==='editar'): ?><a href="pf_carreras.php" class="btn-cancel">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>
 
  <div class="pf-table-card">
    <h2>Listado (<?= count($lista) ?>)</h2>
    <table class="pf-table">
      <thead><tr><th>#</th><th>Carrera</th><th>Clave</th><th>Unidad</th><th>Acciones</th></tr></thead>
      <tbody>
        <?php foreach($lista as $r): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['nombre']) ?></td>
          <td><span class="pf-badge"><?= htmlspecialchars($r['clave']) ?></span></td>
          <td><?= htmlspecialchars($r['unidad']) ?></td>
          <td class="pf-btns">
            <a href="?accion=editar&id=<?= $r['id'] ?>" class="btn-edit">✏️ Editar</a>
            <a href="?accion=eliminar&id=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($lista)): ?><tr><td colspan="5" class="pf-empty">Sin registros</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>