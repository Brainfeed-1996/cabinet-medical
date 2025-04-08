<?php
/**
 * Point d'entrée principal - Redirection vers /public/
 * Path: /htdocs/index.php
 */

// Chemin relatif vérifié
$target = '/public/index.php';
$fullPath = __DIR__ . $target;

if (file_exists($fullPath)) {
    // Log l'accès racine
    file_put_contents(__DIR__ . '/logs/access.log', date('[Y-m-d H:i:s]') . " Root access redirected\n", FILE_APPEND);
    
    // Redirection permanente
    header("Location: {$target}", true, 301);
    exit();
}

// Gestion d'erreur améliorée
http_response_code(500);
include(__DIR__ . '/public/error.php');
exit();
?>