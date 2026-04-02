<?php

function Browser(): string
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $browser = "N/A";

    $browsers = [
        '/msie/i'    => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/chrome/i'  => 'Chrome',
        '/safari/i'  => 'Safari',
        '/edge/i'    => 'Edge',
        '/opera/i'   => 'Opera',
        '/mobile/i'  => 'Mobile Browser',
    ];

    foreach ($browsers as $regex => $value) {
        if ($user_agent && preg_match($regex, $user_agent)) {
            return $value;
        }
    }

    return $browser;
}

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$remoteIp   = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$reference  = $_SERVER['HTTP_REFERER'] ?? '';