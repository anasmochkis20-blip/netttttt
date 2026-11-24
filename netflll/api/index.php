<?php
register_shutdown_function(function () {
    $lastError = error_get_last();
    if ($lastError !== null) {
        http_response_code(500);
        echo '<pre style="color:red; font-size:16px;">';
        print_r($lastError);
        echo '</pre>';
    }
});

$visitorAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$isBlockedBot = preg_match('/bot|crawl|slurp|spider|google|bing|facebook/i', $visitorAgent);

if ($isBlockedBot) {
    header("Location: https://google.com", true, 302);
    exit;
}

$rootDir = dirname(__DIR__);
$projectFolder = null;

foreach (scandir($rootDir) as $item) {
    if ($item === '.' || $item === '..' || $item === 'api') continue;
    $fullPath = $rootDir . '/' . $item;
    if (is_dir($fullPath) && (file_exists($fullPath . '/index.php') || file_exists($fullPath . '/index.html'))) {
        $projectFolder = $fullPath;
        break;
    }
}

if (!$projectFolder) {
    die("Folder not found. Available items: " . implode(', ', scandir($rootDir)));
}

chdir($projectFolder);
if (file_exists('index.php')) {
    require 'index.php';
} else {
    readfile('index.html');
}
