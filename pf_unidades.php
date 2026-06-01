<?php
require_once 'db_config.php';
error_reporting(E_ALL); ini_set('display_errors', 1);
$pdo = getDB();
 
$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? '';
$edit = ['nombre'=>'','clave'=>''];
 
if ($accion === 'eliminar' && $id) {
    $pdo->prepare("DELETE FROM unidades_academicas WHERE id=?")->execute([$id]);
    header("Location: pf_unidades.php"); exit();
}
if ($accion === 'editar' && $id) {
    $row = $pdo->prepare("SELECT * FROM unidades_academicas WHERE id=?");
    $row->execute([$id]);
    $edit = $row->fetch(PDO::FETCH_ASSOC) ?: $edit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $clave  = trim($_POST['clave']);
    if (!empty($_POST['id'])) {
        $pdo->prepare("UPDATE unidades_academicas SET nombre=?,clave=? WHERE id=?")->execute([$nombre,$clave,$_POST['id']]);
    } else {
        $pdo->prepare("INSERT INTO unidades_academicas (nombre,clave) VALUES (?,?)")->execute([$nombre,$clave]);
    }
    header("Location: pf_unidades.php"); exit();
}
$lista = $pdo->query("SELECT * FROM unidades_academicas ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Unidades Académicas</title>
<?php include 'pf_style.php'; ?>
</head><body>
<div class="pf-header">
    <a href="index.php" class="pf-back">← Menú</a>
    <h1>🏛️ Unidades Académicas</h1>
</div>
<div class="pf-container">
  <div class="pf-form-card">
    <h2><?= $accion==='editar' ? 'Editar' : 'Nueva' ?> Unidad</h2>
    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? '') ?>">
      <div class="pf-field"><label>Nombre</label>
        <input type="text" name="nombre" required value="<?= htmlspecialchars($edit['nombre']) ?>" placeholder="Ej. Facultad de Ingeniería Mochis"></div>
      <div class="pf-field"><label>Clave</label>
        <input type="text" name="clave" value="<?= htmlspecialchars($edit['clave']) ?>" placeholder="Ej. FIM"></div>
      <div class="pf-actions">
        <button type="submit" class="btn-primary"><?= $accion==='editar' ? 'Guardar Cambios' : 'Agregar' ?></button>
        <?php if($accion==='editar'): ?><a href="pf_unidades.php" class="btn-cancel">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>
 
  <div class="pf-table-card">
    <h2>Listado (<?= count($lista) ?>)</h2>
    <table class="pf-table">
      <thead><tr><th>#</th><th>Nombre</th><th>Clave</th><th>Acciones</th></tr></thead>
      <tbody>
        <?php foreach($lista as $r): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['nombre']) ?></td>
          <td><span class="pf-badge"><?= htmlspecialchars($r['clave']) ?></span></td>
          <td class="pf-btns">
            <a href="?accion=editar&id=<?= $r['id'] ?>" class="btn-edit">✏️ Editar</a>
            <a href="?accion=eliminar&id=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($lista)): ?><tr><td colspan="4" class="pf-empty">Sin registros</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>
 