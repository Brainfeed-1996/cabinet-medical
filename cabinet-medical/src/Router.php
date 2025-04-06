<?php include("config.php"); ?>

<?php
namespace App;

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

    public function match($method, $path) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $controllerName = "App\\Controllers\\" . $route['controller'];
                $controller = new $controllerName($this->db);
                $action = $route['action'];
                
                $result = $controller->$action();
                
                if (is_string($result)) {
                    return [
                        'template' => $result,
                        'data' => []
                    ];
                }
                
                if (is_array($result) && isset($result['template'])) {
                    return [
                        'template' => $result['template'],
                        'data' => $result['data'] ?? []
                    ];
                }
                
                return [
                    'controller' => 'HomeController@index',
                    'template' => 'home.php', // DOIT être présent
                    'data' => [] // Optionnel
                ];
            }
        }
        throw new \Exception('Route not found');
    }
} 