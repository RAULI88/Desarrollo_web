<form method="POST">
    Nombre: <input type="text" name="nom"> Edad: <input type="number" name="edad">
    <button>Validar</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom']; $edad = $_POST['edad'];
    if ($edad >= 18) { echo "$nom puede votar."; } else { echo "$nom no puede votar."; }
}
?>