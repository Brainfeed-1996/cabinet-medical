<?php
require_once __DIR__ . '/../cabinet-medical/cabinet_medical/config/database.php';

// Affichage temporaire pour debug
echo "<h1>Cabinet Médical</h1>";
echo "<p>Configuration de la base de données :</p>";
echo "<pre>";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "</pre>";
?> 