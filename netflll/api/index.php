<?php
ob_start();
error_reporting(0);

$baseDir = __DIR__ . '/Netflix2026-MultilangPanel';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '') {
    chdir($baseDir);
    require $baseDir . '/index.php';
    exit;
}

$file = $baseDir . $uri;

if (file_exists($file) && !is_dir($file)) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        chdir(dirname($file));
        require $file;
        exit;
    }
    return false;
}

chdir($baseDir);
require $baseDir . '/index.php';
