<form method="POST">Puntuación: <input type="number" name="puntos" min="0" max="100"> <button>Calcular</button></form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p = $_POST['puntos'];
    if ($p >= 90) echo "A";
    elseif ($p >= 80) echo "B";
    elseif ($p >= 70) echo "C";
    elseif ($p >= 60) echo "D";
    else echo "F";
}
?>