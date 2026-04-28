<form method="POST">Celsius: <input type="number" name="c"> <button>Calcular</button></form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $c = $_POST['c'];
    $f = ($c * 9/5) + 32;
    echo "$c Celsius = " . number_format($f, 1) . " Fahrenheit";
}
?>