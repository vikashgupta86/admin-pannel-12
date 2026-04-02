<?php

    require_once '../appcode/globals.inc.php';
    header('Content-Type: application/json');

    function decryptPayload($payload, $seed) {
        if (strlen($payload) < 32) return null;
        try {
            $key = hash('sha256', (string)$seed, true);
            $iv = hex2bin(substr($payload, 0, 32));
            $ciphertext = hex2bin(substr($payload, 32));
            if ($iv === false || $ciphertext === false) return null;
            return openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        } catch (Exception $e) {
            return null;
        }
    }

    if (!isset($_POST['hash_u'], $_POST['hash_p'], $_POST['hash_v'])) 
    {
        echo json_encode(['success' => false, 'error' => 'Security validation failed']);
        exit;
    }

    $seed = $_SESSION['auth_seed'] ?? '';
    if (empty($seed)) 
    {
        echo json_encode(['success' => false, 'error' => 'Session expired, please refresh']);
        exit;
    }

    $uname = decryptPayload($_POST['hash_u'], $seed);
    $pwd   = decryptPayload($_POST['hash_p'], $seed);
    $hash_v = $_POST['hash_v'];

    # print info in pretty format for debugging
    // echo json_encode([
    //     'success' => false,
    //     'error' => 'Debug Info',
    //     'debug' => [
    //         'seed' => $seed,
    //         'uname' => $uname,
    //         'pwd' => $pwd,
    //         'hash_v' => $hash_v,
    //         'expected_hash_v' => hash('sha256', $seed . $uname . $pwd)
    //     ]
    // ], JSON_PRETTY_PRINT);



    if (!$uname || !$pwd || hash('sha256', $seed . $uname . $pwd) !== $hash_v) {
        echo json_encode(['success' => false, 'error' => 'Secure validation failed']);
        exit;
    }

    $uname = trim($uname);
    $pwd = trim($pwd);

    if (($_ENV['CAPTCHA'] ?? 'true') == "true") {
        $sessionCaptcha = $_SESSION['captcha_val'] ?? '';
        if (empty($_POST['T3']) || strtoupper($_POST['T3']) !== $sessionCaptcha) {
            echo json_encode(['success' => false, 'error' => 'Invalid Security Code']);
            exit;
        }
        unset($_SESSION['captcha_val']);
    }

    $conn = db_connect();


$sql = "SELECT user_id, password, user_type_id, department, uname
        FROM web_users
        WHERE status='Active'
          AND current_status='Active'
          AND uname = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
        exit;
    }

    $inputPwdHash = hash('sha256', $pwd);
    if ($inputPwdHash !== $user['password']) 
    {
        echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
        exit;
    }

    $_SESSION['auth_seed'] = bin2hex(random_bytes(32));

    $rand = md5((string)random_int(100000, 999999) . time());

    $_SESSION['userid']     = $user['user_id'];
    $_SESSION['user_type']  = $user['user_type_id'] ?? 0;
    $_SESSION['department'] = $user['department'];
    $_SESSION['web_user']   = true;
    $_SESSION['loginid']    = $rand;
    $_SESSION['Ologinid']   = $rand;

    $EncTok = md5((string)random_int(100000, 999999) . microtime());
    $_SESSION['EncTok'] = $EncTok;

    if (function_exists('csrf_get_tokens')) {
        csrf_get_tokens(); 
    }

    echo json_encode([
        'success' => true,
        "redirect" => "main.php?EncHid=$EncTok"
    ], JSON_PRETTY_PRINT);
