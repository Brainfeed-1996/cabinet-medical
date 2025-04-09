<?php
// 1. Initialisation
define('IN_PUBLIC', true);
require __DIR__.'/../vendor/autoload.php';

// 2. Configuration du logger WAMP
$log = new Monolog\Logger('app');
try {
    $log->pushHandler(new Monolog\Handler\RotatingFileHandler(
        __DIR__.'/../logs/app.log',
        7, // Rotation sur 7 fichiers
        Monolog\Logger::DEBUG
    ));
} catch (Exception $e) {
    die("Erreur logger: ".$e->getMessage());
}

// 3. Exemple d'utilisation
$log->info('Démarrage application', [
    'user' => $_SERVER['USERNAME'] ?? 'cli',
    'wamp' => 'wampapache64'
]);

// ... le reste de votre code ...