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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome</h1>
</body>
</html>
