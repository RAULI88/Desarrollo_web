<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 32 - Calificaciones</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background-color: #f0f4f8; display: flex; justify-content: center; }
        .container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { color: #004a99; margin-top: 0; text-align: center; }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.3s; color: white; background-color: #dc3545; margin-top: 10px; }
        button:hover { opacity: 0.8; }
        .resultado { margin-top: 20px; padding: 15px; border-radius: 4px; background: #e9ecef; font-weight: bold; text-align: center; color: #004a99; font-size: 1.5em; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sistema de Calificaciones</h2>
        <form method="POST">
            <div class="input-group">
                <label>Puntuación (0 al 100):</label>
                <input type="number" name="puntos" min="0" max="100" required>
            </div>
            <button type="submit">Convertir a Letra</button>
        </form>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="resultado">
                <?php 
                    $p = $_POST['puntos'];
                    if ($p >= 90) echo "A";
                    elseif ($p >= 80) echo "B";
                    elseif ($p >= 70) echo "C";
                    elseif ($p >= 60) echo "D";
                    else echo "F";
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>