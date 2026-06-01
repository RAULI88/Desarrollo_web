<?php
require_once 'db_config.php';
error_reporting(E_ALL); ini_set('display_errors', 1);
$pdo = getDB();

$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? '';
$edit = ['nombre'=>'','descripcion'=>'','cantidad_total'=>1,'cantidad_disponible'=>1];

if ($accion === 'eliminar' && $id) {
    $pdo->prepare("DELETE FROM equipos WHERE id=?")->execute([$id]);
    header("Location: pf_equipos.php"); exit();
}
if ($accion === 'editar' && $id) {
    $row = $pdo->prepare("SELECT * FROM equipos WHERE id=?");
    $row->execute([$id]);
    $edit = $row->fetch(PDO::FETCH_ASSOC) ?: $edit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $desc   = trim($_POST['descripcion']);
    $total  = (int)$_POST['cantidad_total'];
    $disp   = (int)$_POST['cantidad_disponible'];
    if (!empty($_POST['id'])) {
        $pdo->prepare("UPDATE equipos SET nombre=?,descripcion=?,cantidad_total=?,cantidad_disponible=? WHERE id=?")->execute([$nombre,$desc,$total,$disp,$_POST['id']]);
    } else {
        $pdo->prepare("INSERT INTO equipos (nombre,descripcion,cantidad_total,cantidad_disponible) VALUES (?,?,?,?)")->execute([$nombre,$desc,$total,$disp]);
    }
    header("Location: pf_equipos.php"); exit();
}
$lista = $pdo->query("SELECT * FROM equipos ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Equipos</title>
<?php include 'pf_style.php'; ?>
</head><body>
<div class="pf-header">
    <a href="index.php" class="pf-back">← Menú</a>
    <h1>💻 Equipos</h1>
</div>
<div class="pf-container">
  <div class="pf-form-card">
    <h2><?= $accion==='editar' ? 'Editar' : 'Nuevo' ?> Equipo</h2>
    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? '') ?>">
      <div class="pf-field"><label>Nombre del Equipo</label>
        <input type="text" name="nombre" required value="<?= htmlspecialchars($edit['nombre']) ?>" placeholder="Ej. Proyector de Video"></div>
      <div class="pf-field"><label>Descripción</label>
        <input type="text" name="descripcion" value="<?= htmlspecialchars($edit['descripcion']) ?>" placeholder="Modelo, características..."></div>
      <div class="pf-row">
        <div class="pf-field"><label>Cantidad Total</label>
          <input type="number" name="cantidad_total" min="1" required value="<?= htmlspecialchars($edit['cantidad_total']) ?>"></div>
        <div class="pf-field"><label>Disponibles</label>
          <input type="number" name="cantidad_disponible" min="0" required value="<?= htmlspecialchars($edit['cantidad_disponible']) ?>"></div>
      </div>
      <div class="pf-actions">
        <button type="submit" class="btn-primary"><?= $accion==='editar' ? 'Guardar Cambios' : 'Agregar' ?></button>
        <?php if($accion==='editar'): ?><a href="pf_equipos.php" class="btn-cancel">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>

  <div class="pf-table-card">
    <h2>Listado (<?= count($lista) ?>)</h2>
    <table class="pf-table">
      <thead><tr><th>#</th><th>Equipo</th><th>Descripción</th><th>Total</th><th>Disp.</th><th>Acciones</th></tr></thead>
      <tbody>
        <?php foreach($lista as $r): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['nombre']) ?></td>
          <td><?= htmlspecialchars($r['descripcion']) ?></td>
          <td><?= $r['cantidad_total'] ?></td>
          <td><span class="pf-badge <?= $r['cantidad_disponible']>0?'badge-ok':'badge-no' ?>"><?= $r['cantidad_disponible'] ?></span></td>
          <td class="pf-btns">
            <a href="?accion=editar&id=<?= $r['id'] ?>" class="btn-edit">✏️ Editar</a>
            <a href="?accion=eliminar&id=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($lista)): ?><tr><td colspan="6" class="pf-empty">Sin registros</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>