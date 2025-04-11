<?php
// Configuration de la connexion MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'cabinetmedical_local');
define('DB_USER', 'root');
define('DB_PASS', ''); // Mot de passe vide en local

// Connexion PDO avec gestion d'erreurs
try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>