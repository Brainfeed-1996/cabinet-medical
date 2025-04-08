
define('IN_PUBLIC', true);
require_once __DIR__ . '/../config.php';
<?php include("config.php"); ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// 1. Chargement des dépendances
require __DIR__ . '/../vendor/autoload.php';

// 2. Initialisation de l'environnement
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
} catch (Exception $e) {
    die("Erreur de configuration: " . $e->getMessage());
}

// 3. Configuration de la base de données
try {
    $db = new PDO(
        "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion DB: " . $e->getMessage());
}

// 4. Initialisation du routeur
use App\Router;

try {
    $router = new Router($db);
    
    // 5. Déclaration des routes
    $router->add('GET', '/', 'HomeController', 'index');
    // Ajoutez d'autres routes ici...
    
    // 6. Traitement de la requête
    $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    
    // 7. Normalisation du chemin
    $basePath = '/cabinet-medical/public';
    if (strpos($requestUri, $basePath) === 0) {
        $requestUri = substr($requestUri, strlen($basePath));
    }
    $requestUri = $requestUri ?: '/';

    // 8. Matching de route
    $route = $router->match($requestMethod, $requestUri);
    
    if (!$route) {
        throw new Exception("Page non trouvée", 404);
    }

    // 9. Validation du template
    $templateFile = $route['template'] ?? null;
    if (empty($templateFile)) {
        throw new Exception("Configuration de route invalide: template manquant", 500);
    }

    $templatePath = realpath(__DIR__ . "/../templates/{$templateFile}");
    if ($templatePath === false || !file_exists($templatePath)) {
        throw new Exception("Template '$templateFile' introuvable", 404);
    }

    // 10. Préparation des données pour la vue
    $viewData = $route['data'] ?? [];
    extract($viewData, EXTR_SKIP);
    
    // 11. Définition des variables pour le layout
    $template = $templatePath;
    $pageTitle = $viewData['title'] ?? 'Cabinet Médical';
    
    // 12. Inclusion du template de base
    require __DIR__ . '/../templates/base.php';

} catch (PDOException $e) {
    http_response_code(500);
    die("Erreur de base de données: " . $e->getMessage());
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    die("Erreur: " . $e->getMessage());
}