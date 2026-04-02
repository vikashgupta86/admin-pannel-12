
<?php

function request_validate_global(array $input) {
    $clean = array();
    foreach ($input as $key => $value) {
        if (!preg_match('/^[a-zA-Z0-9_]{1,999}$/', $key)) {
            _block("Invalid parameter name: " . $key);
        }
        if (is_array($value)) {
            _block("Array input not allowed: " . $key);
        }
        if ($value === '' || $value === null) {
            $clean[$key] = null;
            continue;
        }
        if (strlen($value) > 100) {
            _block("Value too long: " . $key);
        }
        if (ctype_digit($value)) {
            $clean[$key] = (int)$value; 
            continue;
        }
        if (preg_match('/^[a-zA-Z0-9 _\-\.]{1,999}$/', $value)) {
            $clean[$key] = $value;
            continue;
        }
        _block("Invalid value: " . $key);
    }
    return $clean;
}


function _block($message) {
    _log_attack($message);
    header("Location: /");
    die();
}

function _log_attack($message) {
    $line = date('Y-m-d H:i:s') . " | "
          . $_SERVER['REMOTE_ADDR'] . " | "
          . $_SERVER['REQUEST_URI'] . " | "
          . $message . PHP_EOL;


            @file_put_contents(__DIR__ . '/s-e-c-u-r-i-t-y.log', $line, FILE_APPEND);

}

$GLOBALS['_REQ'] = request_validate_global($_GET);

function req($key, $default = null) {
    return isset($GLOBALS['_REQ'][$key]) ? $GLOBALS['_REQ'][$key] : $default;
}



function safe_output($value) {
    return htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
}



// ini_set('session.name', 'PCIMH');
header("X-Content-Type-Options: nosniff");
header("X-HSTS-Test: Active");
header("X-XSS-Protection: 1; mode=block");
header("X-Test-Working: Yes");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

header("Content-Security-Policy: default-src 'self'; form-action 'self'; object-src 'none'; font-src 'self' https://fonts.gstatic.com https://cdn.linearicons.com https://use.fontawesome.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; connect-src 'self' https://translate.googleapis.com https://cdn.jsdelivr.net; img-src 'self' data:; frame-src 'self' *.licdn.com lnkd.demdex.net www.youtube-nocookie.com www.youtube.com player.vimeo.com https://li.protechts.net https://www.facebook.com https://web.facebook.com https://platform.twitter.com https://www.linkedin.com; frame-ancestors 'none'; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; base-uri 'self';");

    
$_ALLOWED_METHODS = ['GET', 'POST'];

// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     header("Access-Control-Allow-Methods: GET, POST");
//     header("Access-Control-Allow-Headers: Content-Type, Authorization");
//     header("HTTP/1.1 204 No Content");
//     exit;
// }
if (!in_array($_SERVER['REQUEST_METHOD'], $_ALLOWED_METHODS)) 
{
    header("Allow: GET, POST");
    header("HTTP/1.1 405 Method Not Allowed");
    echo "405 Method Not Allowed";
    exit;
}
header("Access-Control-Allow-Methods: GET, POST");
header("Allow: GET, POST");

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");
header("Expires: 0");
