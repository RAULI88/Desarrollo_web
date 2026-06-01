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
 
        /* Sección especial para la práctica final */
        .section-title { max-width: 1200px; margin: 30px auto 15px; font-size: 1.1em; font-weight: bold; color: var(--uas-blue); border-bottom: 3px solid var(--uas-gold); padding-bottom: 8px; }
        .final-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; max-width: 1200px; margin: 0 auto 30px; }
        .card-final { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,43,92,0.15); text-decoration: none; color: #333; border-left: 5px solid var(--uas-gold); transition: 0.3s; display: flex; flex-direction: column; position: relative; }
        .card-final:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,43,92,0.2); }
        .card-final h3 { margin: 0 0 8px 0; color: var(--uas-blue); }
        .card-final p { font-size: .88em; color: #555; margin-bottom: 12px; }
        .badge-final { background: var(--uas-blue); color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.78em; font-weight: bold; align-self: flex-start; margin-top: auto; }
        .card-final .icon { font-size: 1.6em; margin-bottom: 8px; }
        .new-tag { position:absolute; top:12px; right:12px; background:var(--uas-gold); color:#333; font-size:.7em; font-weight:700; padding:2px 8px; border-radius:10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PORTAFOLIO DE PRÁCTICAS</h1>
        <p>Facultad de Ingeniería Mochis | Universidad Autónoma de Sinaloa</p>
    </div>
 
    <!-- ===== PRÁCTICAS ANTERIORES ===== -->
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
        <a href="p37.php" class="card"><h3>P37</h3><p>Manejo de Sesiones en PHP.</p><span class="badge">PHP</span></a>
    </div>
 
    <!-- ===== PRÁCTICA FINAL ===== -->
    <div class="section-title">🏆 Ejercicio Final — Sistema de Préstamo de Equipos (FIM)</div>
    <div class="final-grid">
        <a href="pf_unidades.php" class="card-final">
            <span class="new-tag">NUEVO</span>
            <div class="icon">🏛️</div>
            <h3>Unidades Académicas</h3>
            <p>CRUD para gestionar facultades y unidades académicas de la UAS.</p>
            <span class="badge-final">PHP/MySQL</span>
        </a>
        <a href="pf_carreras.php" class="card-final">
            <span class="new-tag">NUEVO</span>
            <div class="icon">🎓</div>
            <h3>Carreras</h3>
            <p>CRUD de carreras vinculadas a su unidad académica correspondiente.</p>
            <span class="badge-final">PHP/MySQL</span>
        </a>
        <a href="p36.php" class="card-final">
            <div class="icon">👤</div>
            <h3>Usuarios</h3>
            <p>CRUD de alumnos y profesores que realizan préstamos de equipos.</p>
            <span class="badge-final">PHP/MySQL</span>
        </a>
        <a href="pf_equipos.php" class="card-final">
            <span class="new-tag">NUEVO</span>
            <div class="icon">💻</div>
            <h3>Equipos</h3>
            <p>CRUD para inventario de equipos: proyectores, laptops, routers, etc.</p>
            <span class="badge-final">PHP/MySQL</span>
        </a>
        <a href="pf_prestamos.php" class="card-final">
            <span class="new-tag">NUEVO</span>
            <div class="icon">📋</div>
            <h3>Préstamo de Equipos</h3>
            <p>Registro de préstamos y devoluciones tal como muestra el formato físico.</p>
            <span class="badge-final">PHP/MySQL</span>
        </a>
        <a href="pf_reportes.php" class="card-final">
            <span class="new-tag">NUEVO</span>
            <div class="icon">📊</div>
            <h3>Reportes</h3>
            <p>Reportes por carrera, por equipo, por usuario y detalle completo con filtro de fechas.</p>
            <span class="badge-final">PHP/MySQL</span>
        </a>
    </div>
</body>
</html>