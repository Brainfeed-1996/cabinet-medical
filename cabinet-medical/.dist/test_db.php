<?php include("config.php"); ?>

<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $db = new PDO(
        "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );
    echo "Connexion à la base de données réussie!";
} catch (PDOException $e) {
    echo "Échec de la connexion: " . $e->getMessage();
}