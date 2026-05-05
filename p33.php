<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 33 - Anagramas</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background-color: #f0f4f8; display: flex; justify-content: center; }
        .container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border-top: 5px solid #002b5c; }
        h2 { color: #004a99; margin-top: 0; text-align: center; }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.3s; color: white; background-color: #004a99; margin-top: 10px; }
        button:hover { opacity: 0.8; }
        .resultado { margin-top: 20px; padding: 15px; border-radius: 4px; background: #e9ecef; font-weight: bold; text-align: center; color: #333; font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Validador de Anagramas</h2>
        <form method="POST">
            <div class="input-group">
                <label>Primera palabra:</label>
                <input type="text" name="palabra1" placeholder="Ej. listen" required>
            </div>
            <div class="input-group">
                <label>Segunda palabra:</label>
                <input type="text" name="palabra2" placeholder="Ej. silent" required>
            </div>
            <button type="submit">Comprobar</button>
        </form>
        
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="resultado">
                <?php 
                    // Limpiar espacios y convertir a minúsculas
                    $p1 = strtolower(trim($_POST['palabra1']));
                    $p2 = strtolower(trim($_POST['palabra2']));
                    
                    // Convertir a arreglos y ordenar
                    $arr1 = str_split($p1);
                    $arr2 = str_split($p2);
                    sort($arr1);
                    sort($arr2);
                    
                    // Comparar
                    if ($arr1 === $arr2) {
                        echo "Sí";
                    } else {
                        echo "No";
                    }
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>