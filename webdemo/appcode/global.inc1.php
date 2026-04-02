<?php

    declare(strict_types=1);
    date_default_timezone_set('Asia/Kolkata');


    error_reporting(E_ALL);
    ini_set('display_errors', '1'); // Change to 1 only in dev

    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (!function_exists('dirname_r')) {
        function dirname_r(string $path, int $count = 1): string {
            for ($i = 0; $i < $count; $i++) {
                $path = dirname($path);
            }
            return $path;
        }
    }
    define('BASE_PATH', dirname_r(__FILE__, 2));

    try {
        require BASE_PATH . '/vendor/autoload.php';


    /*
    |--------------------------------------------------------------------------
    | Load Environment (.env)
    |--------------------------------------------------------------------------
    */
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();

    $dotenv->required(['HOST', 'DB', 'USER_NAME', 'PASS'])->notEmpty();
    $dotenv->required(['DEBUGGING'])->isBoolean();


    /*
    |--------------------------------------------------------------------------
    | Secure Session Configuration
    |--------------------------------------------------------------------------
    */
    session_set_cookie_params([
        'lifetime' => 3600,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();


    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    */

    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('Strict-Transport-Security: max-age=31536000');
    //header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header_remove('X-Powered-By');


    /*
    |--------------------------------------------------------------------------
    | Host Validation (Optional Strict Mode)
    |--------------------------------------------------------------------------
    */

    $allowedHosts = explode(',', $_ENV['ALLOWED_HOSTS'] ?? '');

    if (!empty($allowedHosts)) {

        $currentHost = $_SERVER['HTTP_HOST'] ?? '';

        if (!in_array($currentHost, $allowedHosts, true)) {
            http_response_code(400);
            exit('Invalid Host Header');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | File Upload Size Helpers
    |--------------------------------------------------------------------------
    */

    function parse_size(string $size): int {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $value = (float) preg_replace('/[^0-9\.]/', '', $size);

        if ($unit !== '') {
            return (int) round($value * pow(1024, stripos('bkmgtpezy', strtolower($unit[0]))));
        }

        return (int) round($value);
    }

    function file_upload_max_size(): int{
        $postMax = parse_size(ini_get('post_max_size'));
        $uploadMax = parse_size(ini_get('upload_max_filesize'));

        if ($uploadMax > 0 && $uploadMax < $postMax) {
            return $uploadMax;
        }

        return $postMax;
    }

    define('MAX_UPLOAD_SIZE', file_upload_max_size());


    /*
    |--------------------------------------------------------------------------
    | Database Connection Function (mysqli OOP)
    |--------------------------------------------------------------------------
    */

    function db_connect(): mysqli
    {
        $conn = new mysqli(
            $_ENV['HOST'],
            $_ENV['USER_NAME'],
            $_ENV['PASS'],
            $_ENV['DB'],
            (int) ($_ENV['DB_PORT'] ?? 3306)
        );

        $conn->set_charset('utf8mb4');

        return $conn;
    }


    /*
    |--------------------------------------------------------------------------
    | Safe Query Executor
    |--------------------------------------------------------------------------
    */

    function db_query(string $sql, string $types = '', array $params = []): array
    {
        $conn = db_connect();

        try {

            $stmt = $conn->prepare($sql);

            if ($types !== '' && !empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

            $response = [
                'success' => true,
                'data' => $data,
                'affected_rows' => $stmt->affected_rows,
                'insert_id' => $conn->insert_id
            ];

            $stmt->close();
            $conn->close();

            return $response;

        } catch (Throwable $e) {

            $conn->close();

            error_log("DB Error: " . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Transaction Wrapper
    |--------------------------------------------------------------------------
    */
    function db_transaction(callable $callback): bool
    {
        $conn = db_connect();

        try {

            $conn->begin_transaction();

            $callback($conn);

            $conn->commit();
            $conn->close();

            return true;

        } catch (Throwable $e) {

            $conn->rollback();
            $conn->close();

            error_log("Transaction Error: " . $e->getMessage());

            return false;
        }
    }

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



// Require project-specific PDO file (procedural preferred)
try {
    $pdoFile = __DIR__ . '/usercon_pdo.inc.php';
    if (!is_file($pdoFile) || !is_readable($pdoFile)) {
        throw new RuntimeException('Missing or unreadable: ' . $pdoFile);
    }
    require_once $pdoFile;

    // Prefer procedural initializer functions if available
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

// serverValidate include (procedural usage)
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

// Locale include
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

$PopErrorFlage = false;
