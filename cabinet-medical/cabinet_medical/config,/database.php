<?php
// Configuration de la connexion MySQL avec variables d'environnement
define('DB_HOST', 'localhost');  // Connexion locale
define('DB_NAME', 'cabinetmedical');
define('DB_USER', 'root');
define('DB_PASS', '');  // Mot de passe vide pour la connexion locale

// Connexion PDO avec gestion d'erreurs et affichage des erreurs pour le debug
try {
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
    echo "Tentative de connexion avec DSN: " . $dsn . "<br>";
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "Connexion réussie à la base de données<br>";
    
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage() . "<br>";
    echo "DSN utilisé : mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "<br>";
    die();
}
?>