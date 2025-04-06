<?php include("config.php"); ?>

<?php
class Router {
    private $routes = [];
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function match($requestMethod, $requestPath) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod) {
                $pattern = $this->convertPathToRegex($route['path']);
                if (preg_match($pattern, $requestPath, $matches)) {
                    array_shift($matches); // Retire le premier élément (match complet)
                    $controller = new $route['controller']($this->db);
                    return call_user_func_array([$controller, $route['action']], $matches);
                }
            }
        }
        throw new Exception('Route non trouvée');
    }

    private function convertPathToRegex($path) {
        return '#^' . preg_replace('#\{([a-zA-Z0-9]+)\}#', '([^/]+)', $path) . '$#';
    }
}