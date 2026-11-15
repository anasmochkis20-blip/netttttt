<?php

     

$token = "9108139118:AAEisCNeCi_q_-0DNVTz_icKHkYbrU_dTRc";
$id = "-1003987841987";


// use antibot? yes|no
$antibot = "yes";

 


<?php

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_array($data)) {
    http_response_code(400);
    exit('Invalid request');
}

$name = trim($data['name'] ?? '');
$order = trim($data['order_id'] ?? '');
$status = trim($data['status'] ?? '');

$message =
    "🧪 Demo Notification\n\n" .
    "Name: " . htmlspecialchars($name) . "\n" .
    "Order: " . htmlspecialchars($order) . "\n" .
    "Status: " . htmlspecialchars($status);

if (!$BOT_TOKEN || !$CHAT_ID) {
    http_response_code(500);
    exit('Configuration missing');
}
     . $BOT_TOKEN . "/sendMessage";

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'chat_id' => $CHAT_ID,
        'text' => $message
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10
]);

$result = curl_exec($ch);
curl_close($ch);

echo "OK";
