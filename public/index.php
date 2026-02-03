<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

// ==============================
// LOAD .env (AMAN)
// ==============================
$envFile = BASE_PATH . '/.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // skip comment
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        // skip invalid line
        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// ==============================
// ENV & ERROR MODE
// ==============================
$appEnv = $_ENV['APP_ENV'] ?? 'local'; // 👈 DEFAULT LOCAL (PENTING!)

if ($appEnv === 'local') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// ==============================
// CORE
// ==============================
require_once BASE_PATH . '/app/core/App.php';
require_once BASE_PATH . '/app/core/Router.php';
require_once BASE_PATH . '/app/core/Controller.php';

new App();
