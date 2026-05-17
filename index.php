<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portafolio UAS - FIM</title>
    <style>
        :root { --uas-blue: #002b5c; --uas-gold: #ffc72c; --bg: #f0f4f8; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); margin: 0; padding: 20px; }
        .header { text-align: center; background: var(--uas-blue); color: white; padding: 30px; border-bottom: 5px solid var(--uas-gold); border-radius: 10px 10px 0 0; margin-bottom: 30px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-decoration: none; color: #333; border-left: 5px solid var(--uas-blue); transition: 0.3s; display: flex; flex-direction: column; }
        .card:hover { transform: translateY(-5px); border-left-color: var(--uas-gold); }
        .card h3 { margin: 0 0 10px 0; color: var(--uas-blue); }
        .badge { background: #e9ecef; padding: 5px 10px; border-radius: 4px; font-size: 0.8em; font-weight: bold; align-self: flex-start; margin-top: auto; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PORTAFOLIO DE PRÁCTICAS</h1>
        <p>Facultad de Ingeniería Mochis | Universidad Autónoma de Sinaloa</p>
    </div>
    <div class="grid">
        <a href="p16.html" class="card"><h3>P16</h3><p>Bitácora de Préstamo.</p><span class="badge">HTML/CSS</span></a>
        <a href="p18.html" class="card"><h3>P18</h3><p>Rediseño Web FIM.</p><span class="badge">HTML/CSS</span></a>
        <a href="p19.html" class="card"><h3>P19</h3><p>Salidas de Texto.</p><span class="badge">JS</span></a>
        <a href="p20.html" class="card"><h3>P20</h3><p>Operaciones Básicas.</p><span class="badge">JS</span></a>
        <a href="p21.html" class="card"><h3>P21</h3><p>Calculadora Form.</p><span class="badge">JS</span></a>
        <a href="p22.html" class="card"><h3>P22</h3><p>Fórmula General.</p><span class="badge">JS</span></a>
        <a href="p23.html" class="card"><h3>P23</h3><p>Calculadora IMC.</p><span class="badge">JS</span></a>
        <a href="p24.html" class="card"><h3>P24</h3><p>Fecha con Switch.</p><span class="badge">JS</span></a>
        <a href="p26.html" class="card"><h3>P26</h3><p>Tablas de Multiplicar.</p><span class="badge">JS</span></a>
        <a href="p28.php" class="card"><h3>P28</h3><p>Celsius a Fahrenheit.</p><span class="badge">PHP</span></a>
        <a href="p29.php" class="card"><h3>P29</h3><p>Par o Impar.</p><span class="badge">PHP</span></a>
        <a href="p30.php" class="card"><h3>P30</h3><p>Nombre de Usuario.</p><span class="badge">PHP</span></a>
        <a href="p31.php" class="card"><h3>P31</h3><p>Edad para Votar.</p><span class="badge">PHP</span></a>
        <a href="p32.php" class="card"><h3>P32</h3><p>Puntuación a Letra.</p><span class="badge">PHP</span></a>
        <a href="p33.php" class="card"><h3>P33</h3><p>Validador Anagramas.</p><span class="badge">PHP</span></a>
        <a href="p34.php" class="card"><h3>P34</h3><p>Tipo de Cambio.</p><span class="badge">PHP</span></a>
        <a href="p35.php" class="card"><h3>P35</h3><p>Conversor de Segundos.</p><span class="badge">PHP</span></a>
        <a href="p36.php" class="card"><h3>P36</h3><p>CRUD de Usuarios con MySQL.</p><span class="badge">PHP/MySQL</span></a>
    </div>
</body>
</html>