<?php

require_once 'vendor/autoload.php';
include_once(__DIR__.'/vendor/autoload.php');
use OTPHP\TOTP;

$email = 'chinomsojohnson@gmail.com';
$secret = "{$email}HENNGECHALLENGE003";

$totp = TOTP::create(ParagonIE\ConstantTime\Base32::encode($secret), 30, 'sha512', 10, 0);
$token = $totp->now();
$token = base64_encode( utf8_encode("{$email}:{$token}") );

$url = 'https://api.challenge.hennge.com/challenges/003';
$data = [
    'github_url' => 'https://github.com/Chinomso1995/email',
    'contact_email' => $email
];
$headers = [
    //'Accept' => '/',
    'Content-Type' => 'application/json',
    //'Content-Length' => strlen(json_encode( $data )),
    'Authorization' => 'Basic '. $token
];

PostRequest($url, $data, $headers);

function        PostRequest($url, $data, $headers = [])
{
    $context = curl_init($url);

    curl_setopt($context, CURLOPT_POST, true);
    curl_setopt($context, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($context, CURLOPT_RETURNTRANSFER, true);

    $h = [];
    foreach ($headers as $key => $value) {
        $h[] = "{$key}: {$value}";
    }
    echo "- Headers".PHP_EOL;
    var_dump($h);
    echo "- Data".PHP_EOL;
    var_dump($data);
    curl_setopt($context, CURLOPT_HTTPHEADER, $h);
    $ret = curl_exec($context);
    curl_close($context);

    var_dump($ret);
    return ($ret);
}

?>