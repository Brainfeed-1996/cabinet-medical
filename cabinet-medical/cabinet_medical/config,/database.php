<?php
/**
 * Configuration de la connexion à la base de données
 * Serveur InfinityFree
 */
define('DB_HOST', 'sql108.infinityfree.com');
define('DB_NAME', 'if0_38687649_cabinetmedical');
define('DB_USER', 'if0_38687649');
define('DB_PASS', 'Zinkrobin1'); // Mot de passe réel inséré ici

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $e) {
    // Journalisation de l'erreur (à adapter selon votre environnement)
    error_log("Erreur de connexion DB: " . $e->getMessage());
    
    // Message générique pour l'utilisateur
    die("Impossible de se connecter à la base de données. Veuillez réessayer plus tard.");
}