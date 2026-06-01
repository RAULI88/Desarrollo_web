<?php
// --- CONFIGURACIÓN GLOBAL DE BASE DE DATOS ---
define('DB_HOST', 'zephyr.proxy.rlwy.net');
define('DB_PORT', '30216');
define('DB_NAME', 'railway');
define('DB_USER', 'root');
define('DB_PASS', 'diskLBISvSSxVzPLmlOJFTNzFSCCqeAU');
 
function getDB() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("<div style='background:#ffdddd;color:#d8000c;padding:20px;font-family:sans-serif;border-radius:8px;margin:20px;'>
            <strong>Error de conexión:</strong> " . $e->getMessage() . "
        </div>");
    }
}
?>
 