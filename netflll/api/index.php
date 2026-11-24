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
$isBlockedBot = preg_match('/bot|crawl|slurp|spider|google|bing|facebook|curl|wget|headless|lighthouse/i', $visitorAgent);

if ($isBlockedBot) {
    header("Location: https://google.com", true, 302);
    exit;
}

$projectFolder = __DIR__ . '/my-new-folder';
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestPath === '/' || $requestPath === '') {
    chdir($projectFolder);
    require $projectFolder . '/index.php';
    exit;
}

$targetFile = $projectFolder . $requestPath;

if (file_exists($targetFile) && !is_dir($targetFile)) {
    if (pathinfo($targetFile, PATHINFO_EXTENSION) === 'php') {
        chdir(dirname($targetFile));
        require $targetFile;
        exit;
    }
    return false;
}

chdir($projectFolder);
require $projectFolder . '/index.php';
