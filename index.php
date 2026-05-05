<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portafolio de Prácticas - FIM UAS</title>
    <style>
        :root { --uas-blue: #002b5c; --uas-gold: #ffc72c; --bg: #f4f6f9; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .header { text-align: center; background: var(--uas-blue); color: white; padding: 20px; border-bottom: 5px solid var(--uas-gold); border-radius: 8px 8px 0 0; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; max-width: 1200px; margin: 20px auto; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none; color: #333; border-left: 5px solid var(--uas-blue); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); border-left-color: var(--uas-gold); }
        .badge { background: #e9ecef; padding: 5px 10px; border-radius: 4px; font-size: 0.8em; font-weight: bold; color: var(--uas-blue); }
    </style>
</head>
<body>
    <div class="header">
        <h1>Portafolio de Desarrollo Web</h1>
        <p>Facultad de Ingeniería Mochis</p>
    </div>
    <div class="grid">
        <a href="p16.html" class="card"><h3>Práctica 16</h3><p>Bitácora de Préstamo de Equipos.</p><span class="badge">HTML/CSS</span></a>
        <a href="p18.html" class="card"><h3>Práctica 18</h3><p>Propuesta Rediseño FIM UAS.</p><span class="badge">HTML/CSS</span></a>
        <a href="p19.html" class="card"><h3>Práctica 19</h3><p>Salidas JS (Interactivo).</p><span class="badge">JS Base</span></a>
        <a href="p20.html" class="card"><h3>Práctica 20</h3><p>Operaciones Aritméticas Básicas.</p><span class="badge">JS Lógica</span></a>
        <a href="p21.html" class="card"><h3>Práctica 21</h3><p>Calculadora con Formulario.</p><span class="badge">JS DOM</span></a>
        <a href="p22.html" class="card"><h3>Práctica 22</h3><p>Fórmula General.</p><span class="badge">JS Math</span></a>
        <a href="p23.html" class="card"><h3>Práctica 23</h3><p>Calculadora IMC.</p><span class="badge">JS Condicionales</span></a>
        <a href="p24.html" class="card"><h3>Práctica 24</h3><p>Fecha con Switch.</p><span class="badge">JS Date</span></a>
        <a href="p26.html" class="card"><h3>Práctica 26</h3><p>Tablas Dinámicas (1 al N).</p><span class="badge">JS For Dinámico</span></a>
        <a href="p28.php" class="card"><h3>Práctica 28</h3><p>Celsius a Fahrenheit.</p><span class="badge">PHP Form</span></a>
        <a href="p29.php" class="card"><h3>Práctica 29</h3><p>Validador Par / Impar.</p><span class="badge">PHP Lógica</span></a>
        <a href="p30.php" class="card"><h3>Práctica 30</h3><p>Generador de Usuario.</p><span class="badge">PHP Strings</span></a>
        <a href="p31.php" class="card"><h3>Práctica 31</h3><p>Validador de Edad.</p><span class="badge">PHP If/Else</span></a>
        <a href="p32.php" class="card"><h3>Práctica 32</h3><p>Puntuación a Letra.</p><span class="badge">PHP Condicional</span></a>
    </div>
</body>
</html>