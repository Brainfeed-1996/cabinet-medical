<?php
/**
 * Configuration MySQL sécurisée pour cabinet médical
 * Path: /htdocs/config.php
 */

// Désactiver l'affichage direct des erreurs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/php_errors.log');

// Configuration BDD
define('DB_HOST', 'sql108.infinityfree.com');
define('DB_USER', 'if0_38687649');
define('DB_PASS', 'Zinkrobin1');
define('DB_NAME', 'if0_38687649_cabinetmedical');

// Fonction de connexion sécurisée
function getDBConnection() {
    static $conn = null;
    
    if ($conn === null) {
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $conn->set_charset("utf8mb4");
            
            if ($conn->connect_errno) {
                throw new Exception("DB_CONNECTION_ERROR");
            }
        } catch (Exception $e) {
            error_log(date('[Y-m-d H:i:s]') . " MySQL Error: " . $conn->connect_error, 3, __DIR__ . '/logs/db_errors.log');
            header("Location: /public/error.php?code=db");
            exit();
        }
    }
    
    return $conn;
}

// Initialisation automatique si le fichier est inclus depuis public/index.php
if (defined('IN_PUBLIC') && IN_PUBLIC === true) {
    $GLOBALS['db'] = getDBConnection();
}