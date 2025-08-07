<?php
session_start();

/**
 * Simple Router for Chamber of Commerce CRM
 */
class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash except for root
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $method, $path)) {
                $controller = new $route['controller']();
                $action = $route['action'];
                
                // Extract parameters from path
                $params = $this->extractParams($route['path'], $path);
                
                if (!empty($params)) {
                    call_user_func_array([$controller, $action], $params);
                } else {
                    $controller->$action();
                }
                return;
            }
        }

        // 404 Not Found
        $this->notFound();
    }

    private function matchRoute($route, $method, $path) {
        if ($route['method'] !== $method) {
            return false;
        }

        $routePath = $route['path'];
        
        // Convert route path to regex
        $routeRegex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $routeRegex = '#^' . $routeRegex . '$#';

        return preg_match($routeRegex, $path);
    }

    private function extractParams($routePath, $actualPath) {
        $routeRegex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $routeRegex = '#^' . $routeRegex . '$#';

        preg_match($routeRegex, $actualPath, $matches);
        array_shift($matches); // Remove full match

        return $matches;
    }

    private function notFound() {
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
        echo '<p><a href="/">Volver al inicio</a></p>';
    }
}

// Initialize router
$router = new Router();

// Include controllers
require_once __DIR__ . '/../controllers/AfiliacionController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

// Public routes
$router->addRoute('GET', '/', 'AfiliacionController', 'showForm');
$router->addRoute('GET', '/afiliacion', 'AfiliacionController', 'showForm');
$router->addRoute('POST', '/afiliacion', 'AfiliacionController', 'procesar');
$router->addRoute('GET', '/afiliacion/confirmacion', 'AfiliacionController', 'showConfirmacion');

// Admin authentication routes
$router->addRoute('GET', '/admin/login', 'AuthController', 'showLogin');
$router->addRoute('POST', '/admin/login', 'AuthController', 'login');
$router->addRoute('GET', '/admin/logout', 'AuthController', 'logout');

// Admin dashboard routes
$router->addRoute('GET', '/admin', 'AdminController', 'dashboard');
$router->addRoute('GET', '/admin/dashboard', 'AdminController', 'dashboard');
$router->addRoute('GET', '/admin/afiliaciones', 'AdminController', 'afiliaciones');
$router->addRoute('GET', '/admin/afiliacion/{id}', 'AdminController', 'detalleAfiliacion');
$router->addRoute('POST', '/admin/afiliacion/actualizar', 'AdminController', 'actualizarEstatus');
$router->addRoute('GET', '/admin/exportar', 'AdminController', 'exportarCSV');
$router->addRoute('GET', '/admin/api/charts', 'AdminController', 'getChartData');

// Dispatch the request
$router->dispatch();
?>