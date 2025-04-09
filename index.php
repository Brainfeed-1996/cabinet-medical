<?php
/**
 * Point d'entrée sécurisé - Redirection vers /public/
 */
$basePath = '/'; // À adapter si sous-dossier
$target = $basePath . 'public/index.php';
$fullPath = __DIR__ . $target;

// Log sécurisé
$logPath = __DIR__ . '/private/logs/access.log';
if (!is_dir(dirname($logPath))) {
    mkdir(dirname($logPath), 0750, true);
}

file_put_contents(
    $logPath,
    sprintf(
        "[%s] %s\n",
        date('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'] . ' ' . ($_SERVER['HTTP_REFERER'] ?? 'direct')
    ),
    FILE_APPEND | LOCK_EX
);

// Redirection
if (file_exists($fullPath)) {
    header("Location: " . filter_var($target, FILTER_SANITIZE_URL), true, 301);
    exit;
}

// Fallback sécurisé
http_response_code(500);
if (file_exists(__DIR__ . '/public/error.php')) {
    include __DIR__ . '/public/error.php';
} else {
    header('Content-Type: text/plain');
    die('Erreur interne : configuration invalide');
}
?>