<form method="POST">Número: <input type="number" name="num"> <button>Verificar</button></form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n = $_POST['num'];
    echo ($n % 2 == 0) ? "Par" : "Impar";
}
?>