<?php

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        $view = str_replace('.', '/', $view);
        $viewPath = dirname(__DIR__) . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View tidak ditemukan: " . $viewPath);
        }

        require $viewPath;
    }

    protected function model($model)
    {
        $modelPath = dirname(__DIR__) . '/models/' . $model . '.php';

        if (!file_exists($modelPath)) {
            die("Model tidak ditemukan: " . $modelPath);
        }

        require_once $modelPath;
        return new $model;
    }
    protected function auth()
{
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }
}

}
