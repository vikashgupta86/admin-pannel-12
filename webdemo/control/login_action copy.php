<?php
    namespace Nullix\JsAesPhp;

    require_once '../appcode/globals.inc.php';



    require_once '../vendor/js-aes-php/js-aes-php.php';

    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_samesite', 'Strict');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    session_start();

    header('Content-Type: application/json');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');

    function sendResponse($success, $message, $data = [], $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message,
            'timestamp' => date('c')
        ]));
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_token') {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (empty($_SESSION['crypto_secret'])) {
            $_SESSION['crypto_secret'] = bin2hex(random_bytes(16));
        }
        $_SESSION['captcha_authorized'] = true;
        sendResponse(true, 'Security context established', [
            'csrf_token' => $_SESSION['csrf_token'],
        '   crypto_secret' => $_SESSION['crypto_secret']
    ]   );
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJson = file_get_contents('php://input');
        $data = json_decode($inputJson, true);

        if (!$data) {
            sendResponse(false, 'Invalid JSON payload', [], 400);
        }

        $clientToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $data['csrf_token'] ?? '';
        if (empty($clientToken) || !hash_equals($_SESSION['csrf_token'] ?? '', $clientToken)) {
            sendResponse(false, 'Validation Failed.', [], 403);
        }

        if (empty($data['email']) || empty($data['password']) || empty($data['captcha'])) {
            sendResponse(false, 'Missing required fields', [], 422);


        $sessionCaptcha = $_SESSION['captcha'] ?? '';
        if (empty($data['captcha']) || strtoupper($data['captcha']) !== $sessionCaptcha) {
            sendResponse(false, 'Invalid Captcha Code', [], 403);
        }
        unset($_SESSION['captcha']);

        try {
            $startTime = microtime(true);

            $sessionSecret = $_SESSION['crypto_secret'] ?? '';
            $decryptedEmail = JsAesPhp::decrypt($data['email'], $sessionSecret);
            $decryptedPassword = JsAesPhp::decrypt($data['password'], $sessionSecret);

            $processingTime = round((microtime(true) - $startTime) * 1000, 2);

            $validEmail = "sacxe@proton.me";
            $validPassword = "MangoMan@123";

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['crypto_secret'] = bin2hex(random_bytes(16));
            $newTokens = [
                'new_csrf_token' => $_SESSION['csrf_token'],
                'new_crypto_secret' => $_SESSION['crypto_secret']
        ]   ;

            if ($decryptedEmail === $validEmail && $decryptedPassword === $validPassword) {
                $_SESSION['user_authenticated'] = true;
                $_SESSION['user_email'] = $decryptedEmail;
            
                $auditTrail = [
                    'event' => 'LOGIN_SUCCESS',
                    'client_ip' => $_SERVER['REMOTE_ADDR'],
                    'user' => $decryptedEmail,
                    // 'processing_ms' => $processingTime
                ];

                sendResponse(true, 'Authentication Successful', array_merge($newTokens, [
                    'redirect_url' => 'main.php',
                    'audit' => $auditTrail
                ]));
            } else {
                $auditTrail = [
                    'event' => 'LOGIN_FAILED',
                    //'client_ip' => $_SERVER['REMOTE_ADDR'],
                    //'user_attempted' => $decryptedEmail
                ];

                sendResponse(false, 'Invalid credentials.', array_merge($newTokens, [
                    'audit' => $auditTrail
                ]), 401);
            }

        } catch (\Throwable $e) {
            sendResponse(false, 'Secure authenticaion failed.', ['error' => $e->getMessage()], 403);
        }
    }
}
sendResponse(false, 'Method not allowed', [], 405);
