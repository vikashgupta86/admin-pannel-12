<?php
// declare(strict_types=1);



/**
 * =====================================================
 * ENTERPRISE APPLICATION BOOTSTRAP
 * =====================================================
 */

define('APP_START', microtime(true));
$root = realpath(__DIR__);

while (!is_dir($root . DIRECTORY_SEPARATOR . 'vendor') && dirname($root) !== $root) {
    $root = dirname($root);
}

define('BASE_PATH', $root);

echo $root;

define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');

date_default_timezone_set('Asia/Kolkata');

/**
 * -----------------------------------------------------
 * Load Composer & Environment
 * -----------------------------------------------------
 */
try {
    require BASE_PATH . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->safeLoad();

} catch (Throwable $e) {
    http_response_code(500);
    error_log("Bootstrap Fatal: " . $e->getMessage());
    exit('Application failed to initialize.');
}

/**
 * -----------------------------------------------------
 * Environment Detection
 * -----------------------------------------------------
 */
$debug = filter_var($_ENV['DEBUGGING'] ?? false, FILTER_VALIDATE_BOOLEAN);

error_reporting(E_ALL);
ini_set('display_errors', $debug ? '1' : '0');
ini_set('log_errors', '1');

/**
 * -----------------------------------------------------
 * Global Exception & Error Handling
 * -----------------------------------------------------
 */
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function (Throwable $e) use ($debug) {

    error_log(sprintf(
        "[%s] %s in %s:%d",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    ));

    http_response_code(500);

    if ($debug) {
        echo "<h2>Unhandled Exception</h2>";
        echo "<pre>" . htmlspecialchars((string)$e) . "</pre>";
    } else {
        echo "Internal Server Error";
    }
});

register_shutdown_function(function () use ($debug) {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR])) {
        error_log("Shutdown Fatal: " . print_r($error, true));
        http_response_code(500);
        if (!$debug) {
            echo "Internal Server Error";
        }
    }
});

/**
 * -----------------------------------------------------
 * Secure Session Configuration
 * -----------------------------------------------------
 */
if (session_status() === PHP_SESSION_NONE) {

    session_name($_ENV['APP_NAME'] ?? 'APPSESSID');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => $_ENV['SESSION_DOMAIN'] ?? '',
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    session_start();

    // Regenerate on first load
    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
    }
}

/**
 * -----------------------------------------------------
 * Security Headers
 * -----------------------------------------------------
 */
header_remove('X-Powered-By');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
header('Content-Type: text/html; charset=UTF-8');

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload');
}

/**
 * Content Security Policy
 * Adjust for your app needs
 */


function sendSecurityHeaders(): void
{
    header_remove('X-Powered-By');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
    header('Content-Type: text/html; charset=UTF-8');

/*
USE THIS
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.cookie_samesite', 'Strict');

session_start();
*/



    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload');
    }

    $csp = "default-src 'self'; "
         . "script-src 'self'; "
         . "style-src 'self'; "
         . "img-src 'self' data:; "
         . "font-src 'self'; "
         . "connect-src 'self'; "
         . "frame-ancestors 'self'; "
         . "base-uri 'self'; "
         . "form-action 'self'";

    header('Content-Security-Policy: ' . $csp);
}
#sendSecurityHeaders();



/**
 * -----------------------------------------------------
 * Output Buffer (Compression Safe)
 * -----------------------------------------------------
 */
if (!headers_sent()) {
    if (extension_loaded('zlib') && !in_array('ob_gzhandler', ob_list_handlers(), true)) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }
}

/**
 * -----------------------------------------------------
 * Host Header Protection
 * -----------------------------------------------------
 */
$allowedHosts = array_filter(array_map('trim', explode(',', $_ENV['ALLOWED_HOSTS'] ?? '')));
if (!empty($allowedHosts)) {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (!in_array($host, $allowedHosts, true)) {
        http_response_code(400);
        exit('Invalid Host Header');
    }
}

/**
 * -----------------------------------------------------
 * Database Strict Mode (MySQLi)
 * -----------------------------------------------------
 */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * -----------------------------------------------------
 * Core Includes
 * -----------------------------------------------------
 */
require_once BASE_PATH . '/appcode/usercon_pdo.inc.php';
require_once BASE_PATH . '/appcode/upload_class.inc.php';
require_once BASE_PATH . '/appcode/web_security.inc.php';
require BASE_PATH . '/appcode/WebCheck.inc.php';

$serverValidate = BASE_PATH . '/appcode/serverValidate.inc.php';
if (is_file($serverValidate)) {
    require_once $serverValidate;
}

/**
 * -----------------------------------------------------
 * Locale Loader
 * -----------------------------------------------------
 */
$localeFile = BASE_PATH . '/Locale/locale.inc.php';
if (is_file($localeFile)) {
    require_once $localeFile;
}

// include dirname_r(__FILE__, 3) .'/assets/csrf-magic/csrf-magic.php';

require_once BASE_PATH . '/vendor/csrf-magic/csrf-magic.php';

/**
 * =====================================================
 * APPLICATION READY
 * =====================================================
 */
