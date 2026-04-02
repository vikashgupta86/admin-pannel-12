<?php

    declare(strict_types=1);

    if (!function_exists('dirname_r')) {
        function dirname_r(string $path, int $count = 1): string {
            for ($i = 0; $i < $count; $i++) {
                $path = dirname($path);
            }
            return $path;
        }
    }
    define('BASE_PATH', dirname_r(__FILE__, 2));
    define('PATH', value: $_SERVER['SCRIPT_NAME'] ?? '');

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
        if (!empty($_ENV['DEBUGGING']) && $_ENV['DEBUGGING'] === 'true') {
            echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        } else {
            echo "Internal Server Error";
        }
        exit;
    }


    error_reporting(E_ALL);
    ini_set('display_errors', '1'); // Change to 1 only in dev

    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


    session_set_cookie_params([
#        'lifetime' => 3600,
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => null,
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();


    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('Content-Type: text/html; charset=utf-8');
    header('Strict-Transport-Security: max-age=31536000');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header_remove('X-Powered-By');


    error_reporting(E_ALL);
    ini_set('display_errors', '0');

    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');

    session_name($_ENV['APP_NAME'] ?? 'APPSESSID');
    session_start();

    if (!in_array('ob_gzhandler', ob_list_handlers(), true)) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }


    set_time_limit(300);

    $allowedHosts = explode(',', $_ENV['ALLOWED_HOSTS'] ?? '');

    if (!empty($allowedHosts)) {
        $currentHost = $_SERVER['HTTP_HOST'] ?? '';
        if (!in_array($currentHost, $allowedHosts, true)) {
            http_response_code(400);
            exit('Invalid Host Header');
        }
    }

    require_once 'upload_class.inc.php';
    require_once 'web_security.inc.php';






    /*
    try {
        $pdoFile = __DIR__ . '/usercon_pdo.inc.php';
        if (!is_file($pdoFile) || !is_readable($pdoFile)) {
            throw new RuntimeException('Missing or unreadable: ' . $pdoFile);
        }
        require_once $pdoFile;

        if (function_exists('pdo_connect')) {
            $obj = pdo_connect();
        } elseif (function_exists('get_pdo_connection')) {
            $obj = get_pdo_connection();
        } else {
            $obj = null;
        }
    } catch (Throwable $e) {
        error_log('PDO include/instantiation error: ' . $e->getMessage());
        // echo 'PDO error: ' . $e->getMessage();
        throw $e;
    }

    */
    try {
        $sv = __DIR__ . '/serverValidate.inc.php';
        if (is_file($sv) && is_readable($sv)) {
            include_once $sv;
            if (function_exists('checks_init')) {
                $chk = checks_init();
            } elseif (function_exists('run_checks')) {
                $chk = run_checks();
            } else {
                $chk = null;
            }
        }
    } catch (Throwable $e) {
        error_log('serverValidate include error: ' . $e->getMessage());
        // echo 'serverValidate error: ' . $e->getMessage();
        throw $e;
    }

    try {
        $localeFile = dirname_r(__FILE__, 2) . '/Locale/locale.inc.php';
        if (is_file($localeFile) && is_readable($localeFile)) {
            include_once $localeFile;
        }
    } catch (Throwable $e) {
        error_log('Locale include error: ' . $e->getMessage());
        // echo 'Locale error: ' . $e->getMessage();
        throw $e;
    }


    include_once BASE_PATH ."/Locale/locale.inc.php";



    $PopErrorFlage = false;
