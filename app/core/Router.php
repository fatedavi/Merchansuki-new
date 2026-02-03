<?php

class Router
{
    private array $routes = [];

    public function get(string $route, string $action): void
    {
        $this->routes['GET'][trim($route, '/')] = $action;
    }

    public function post(string $route, string $action): void
    {
        $this->routes['POST'][trim($route, '/')] = $action;
    }

public function dispatch()
{
    $method = $_SERVER['REQUEST_METHOD'];

    // Ambil path murni (AMAN DI HOSTING)
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');

    // Hilangkan index.php kalau ada
    if (str_starts_with($uri, 'index.php')) {
        $uri = trim(substr($uri, strlen('index.php')), '/');
    }

    if (!isset($this->routes[$method])) {
        http_response_code(405);
        die('Method Not Allowed');
    }

    foreach ($this->routes[$method] as $route => $handler) {

        // Convert {param} ke regex
        $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
        $pattern = "#^$pattern$#";

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches);

            [$controller, $action] = explode('@', $handler);

            if (!class_exists($controller)) {
                die("Controller $controller tidak ditemukan");
            }

            $controller = new $controller();

            if (!method_exists($controller, $action)) {
                die("Method $action tidak ditemukan");
            }

            call_user_func_array([$controller, $action], $matches);
            return;
        }
    }

    http_response_code(404);
    die('404 Not Found');
}



    private function match(string $route, string $url): array|false
    {
        $routeParts = explode('/', $route);
        $urlParts   = explode('/', $url);

        if (count($routeParts) !== count($urlParts)) {
            return false;
        }

        $params = [];

        foreach ($routeParts as $i => $part) {
            if (preg_match('/^{.+}$/', $part)) {
                $params[] = $urlParts[$i];
            } elseif ($part !== $urlParts[$i]) {
                return false;
            }
        }

        return $params;
    }

    private function notFound(string $url): void
    {
        http_response_code(404);
        echo "ROUTE TIDAK DITEMUKAN: $url";
        exit;
    }
}
