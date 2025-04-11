<?php
// Affichage des erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Cabinet Médical - Test de connexion</h1>";

// Définir le chemin correct vers le fichier de configuration
$config_file = __DIR__ . '/../cabinet-medical/cabinet_medical/config/database.php';
echo "Chemin du fichier de configuration : " . $config_file . "<br>";

if (!file_exists($config_file)) {
    die("Erreur : Le fichier de configuration n'existe pas à l'emplacement : " . $config_file);
}

// Tentative de connexion à la base de données
require_once $config_file;

// Si on arrive ici, c'est que la connexion est réussie (sinon une exception aurait été levée)
echo "<p style='color: green;'>Connexion à la base de données réussie !</p>";

// Affichage des informations de configuration
echo "<h2>Configuration actuelle :</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Script Path: " . __FILE__ . "\n";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "</pre>";

// Test de requête simple
try {
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color: green;'>Test de requête réussi !</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erreur lors du test de requête : " . $e->getMessage() . "</p>";
}
?> 