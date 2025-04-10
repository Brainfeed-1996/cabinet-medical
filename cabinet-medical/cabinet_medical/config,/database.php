<?php
// Configuration dans un fichier séparé (à créer)
$config = [
    'db_host' => 'sql108.infinityfree.com',
    'db_name' => 'if0_38687649_cabinetmedical',
    'db_user' => 'if0_38687649',
    'db_pass' => 'Zinkrobin1'
];

try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
        $config['db_user'],
        $config['db_pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log("Erreur DB: " . $e->getMessage());
    die("Service temporairement indisponible");
}