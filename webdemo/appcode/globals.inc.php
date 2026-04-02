<?php
    declare(strict_types=1);

ini_set('session.cookie_httponly', 1);

    ini_set('session.use_only_cookies', 1);


 ini_set('session.cookie_secure', 1);
 ini_set('session.cookie_samesite', 'Lax');

    if (!defined('CPATH')) define('CPATH', '/');

    if (!function_exists('dirname_r')) {
        function dirname_r(string $path, int $count = 1): string {
            for ($i = 0; $i < $count; $i++) {
                $path = dirname($path);
            }
            return $path;
        }
    }

    if (!defined('BASE_PATH')) {
        define('BASE_PATH', dirname_r(__FILE__, 2));
    }

    if (!defined('PATH')) {
        define('PATH', $_SERVER['SCRIPT_NAME'] ?? '');
    }

    date_default_timezone_set('Asia/Kolkata');

    try {

    require BASE_PATH . '/vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
        $dotenv->load();
        $dotenv->required(['HOST', 'DB', 'USER_NAME', 'PASS'])->notEmpty();
        $dotenv->required(['DEBUGGING'])->isBoolean();
    } catch (Throwable $e) {
        error_log("Bootstrap Error: " . $e->getMessage());
        http_response_code(500);
        echo !empty($_ENV['DEBUGGING']) && $_ENV['DEBUGGING'] === 'true' ? "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>" : "Internal Server Error";
        exit;
    }

    $debug = filter_var($_ENV['DEBUGGING'] ?? false, FILTER_VALIDATE_BOOLEAN);

    error_reporting(E_ALL);
    ini_set('display_errors', $debug ? '1' : '0');
    ini_set('log_errors', '1');

    set_error_handler(fn($severity, $message, $file, $line) => throw new ErrorException($message, 0, $severity, $file, $line));

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (session_status() === PHP_SESSION_NONE) 
    {
        session_name($_ENV['APP_NAME'] ?? 'APPSESSID');

        $session_domain = !empty($_ENV['SESSION_DOMAIN']) ? $_ENV['SESSION_DOMAIN'] : null;        
        session_set_cookie_params([
            'lifetime' => 3600,
            'path'     => '/',
#            'domain'   => $_ENV['SESSION_DOMAIN'] ?? '',
            'domain'   => null,
#            'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

#        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        session_start();
    }

    if (!ob_get_level()) {
        if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }
    }

    header_remove('X-Powered-By');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('Content-Type: text/html; charset=utf-8');
#    header('Strict-Transport-Security: max-age=31536000');
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    // header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');

    set_time_limit(300);

    $allowedHosts = array_filter(array_map('trim', explode(',', $_ENV['ALLOWED_HOSTS'] ?? '')));
    if (!empty($allowedHosts)) {
        $currentHost = $_SERVER['HTTP_HOST'] ?? '';
        if (!in_array($currentHost, $allowedHosts, true)) {
            http_response_code(400);
            exit('Invalid Host Header');
        }
    }

    require_once BASE_PATH . '/appcode/upload_class.inc.php';
    require_once BASE_PATH . '/appcode/web_security.inc.php';
    require_once BASE_PATH . '/appcode/purifier.inc.php';
    require_once BASE_PATH . '/appcode/usercon_pdo.inc.php';
    require_once BASE_PATH . '/vendor/csrf-magic/csrf-magic.php';

    #======================||   SEPARATE FILE FOR USER CONTROL PANEL    ||======================
    require_once BASE_PATH . '/appcode/userControl.inc.php';



    $GLOBALS['csrf']['secret'] = 'SANJAYPAL';
    $GLOBALS['csrf']['allow-ip'] = true;


    if (!function_exists('safeRequireFiles')) {
        function safeRequireFiles(array $files, bool $debug = false, bool $exitOnFail = true): void {
            foreach ($files as $file) {
                try {
                    if (!is_file($file) || !is_readable($file)) {
                        throw new RuntimeException("File not found or not readable: $file");
                    }
                    require_once $file;
                } catch (Throwable $e) {
                    error_log("Failed to load file: " . $e->getMessage());
                    if ($debug) {
                        echo "<pre>Error loading {$file}: " . htmlspecialchars($e->getMessage()) . "</pre>";
                    }
                    if ($exitOnFail) {
                        http_response_code(500);
                        exit("Application initialization failed. Check logs for details.");
                    }
                }
            }
        }
    }
    $filesToLoad = [
        BASE_PATH . '/appcode/upload_class.inc.php',
        BASE_PATH . '/appcode/web_security.inc.php',
        BASE_PATH . '/vendor/csrf-magic/csrf-magic.php',
    ];

    $debug = !empty($_ENV['DEBUGGING']) && $_ENV['DEBUGGING'] === 'true';
    safeRequireFiles($filesToLoad, $debug);


    // $serverValidate = BASE_PATH . '/appcode/serverValidate.inc.php';
    // if (is_file($serverValidate) && is_readable($serverValidate)) {
    //     include_once $serverValidate;
    //     if (function_exists('checks_init')) {
    //         $chk = checks_init();
    //     } elseif (function_exists('run_checks')) {
    //         $chk = run_checks();
    //     }
    // }
    // $chk = new checks();


    $localeFile = BASE_PATH . '/Locale/locale.inc.php';
    if (is_file($localeFile) && is_readable($localeFile)) {
        include_once $localeFile;
    }

    $PopErrorFlag = false;

    function e($v) {
    //  return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
    return clean_htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');

}



function safeFile($v) {
    return basename($v ?? '');
}


// header("Content-Security-Policy: default-src 'self'; form-action 'self'; object-src 'none'; font-src 'self' https://fonts.gstatic.com https://cdn.linearicons.com https://use.fontawesome.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://use.fontawesome.com/releases/v5.15.4/css/all.css; connect-src 'self' https://translate.googleapis.com https://cdn.jsdelivr.net; img-src 'self' data:; frame-src 'self' *.licdn.com lnkd.demdex.net www.youtube-nocookie.com www.youtube.com player.vimeo.com https://li.protechts.net https://www.facebook.com https://web.facebook.com https://platform.twitter.com https://www.linkedin.com; frame-ancestors 'none'; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; base-uri 'self';");


$PopErrorFlage=false;

$conn = db_connect();

$nonce = '';
// if ($_ENV['AUDIT'] === true) {
//     $nonce_val = bin2hex(random_bytes(16));
//     $nonce = ' nonce="' . htmlspecialchars($nonce_val) . '"';
// } else {
//     $nonce = '';
// }

// // echo "<script>console.log('" . $_ENV['AUDIT'] . "---- NONCE: . "   " ');</script>";

$_ALLOWED_METHODS = ['GET', 'POST'];

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



require_once BASE_PATH . '/appcode/core_security.inc.php';
