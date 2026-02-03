<?php

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/',               
        __DIR__ . '/../controllers/',
        __DIR__ . '/../models/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

class App
{
    public function __construct()
    {
        $router = require __DIR__ . '/Routes.php';

        if (!$router instanceof Router) {
            die('Router gagal dimuat');
        }

        $router->dispatch();
    }
}
