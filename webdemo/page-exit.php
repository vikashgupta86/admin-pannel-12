<?php
declare(strict_types=1);

require './appcode/globals.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}


$pageurl = $_POST['pageurl'] ?? '';

if ($pageurl === '' || strlen($pageurl) > 500) {
    http_response_code(400);
    exit('Invalid Page URL');
}


$ip = $_SERVER['REMOTE_ADDR'] ?? '';

if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    http_response_code(400);
    exit('Invalid IP');
}


$timenow = date('Y-m-d H:i:s');
$today   = date('Y-m-d');


$sql = "
    UPDATE analytics
    SET exit_time = ?
    WHERE ip_address = ?
      AND page_url = ?
      AND DATE(entry_time) = ?
";

try {

    $result = core_query(
        $sql,
        "ssss",
        [$timenow, $ip, $pageurl, $today]
    );

    if (!$result['success']) {
        http_response_code(500);
        exit('Update Failed');
    }

    echo 'OK';

} catch (Throwable $e) {

    if (function_exists('app_log')) {
        app_log('page-exit error: ' . $e->getMessage());
    }

    http_response_code(500);
    exit('Server Error');
}
