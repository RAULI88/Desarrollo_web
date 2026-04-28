<form method="POST">
    Nombre: <input type="text" name="nom"> Apellido: <input type="text" name="ape">
    <button>Generar</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom']; $ape = $_POST['ape'];
    $user = strtolower(str_replace(' ', '', $nom . $ape));
    $ini = strtoupper(substr($nom, 0, 1) . substr($ape, 0, 1));
    echo "Nombre de usuario: $user <br>Iniciales (en mayúsculas): $ini";
}
?>