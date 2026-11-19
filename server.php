<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/' || $path === '') {
    header('Location: /frontend/');
    return true;
}

if (strpos($path, '/backend') === 0) {
    $file = __DIR__ . $path;

    if (is_dir($file) && is_file(rtrim($file, '/') . '/index.html')) {
        if (substr($path, -1) !== '/') {
            header("Location: $path/");
            return true;
        }
        header('Content-Type: text/html; charset=utf-8');
        readfile(rtrim($file, '/') . '/index.html');
        return true;
    }

    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
        return false;
    }

    if (is_file($file) && basename($file) !== 'index.php') {
        chdir(dirname($file));
        require $file;
        return true;
    }

    $_SERVER['SCRIPT_NAME'] = '/backend/index.php';
    chdir(__DIR__ . '/backend');
    require __DIR__ . '/backend/index.php';
    return true;
}

return false;
