<?php include("config.php"); ?>

<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cabinet_medical');
define('DB_USER', 'root');  // utilisateur par défaut de XAMPP
define('DB_PASS', '');      // mot de passe vide par défaut

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}