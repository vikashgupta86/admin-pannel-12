<?php
require_once '../appcode/globals.inc.php';

header('Content-Type: application/json');
function getCookieParam(int $lifetime = 0): array
{
    $params = session_get_cookie_params();

    return [
        'expires'  => $lifetime > 0 ? time() + $lifetime : 0,
        'path'     => $params['path'] ?? '/',
        'domain'   => $params['domain'] ?? '',
        'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ];
}


if (!isset($_POST['hash'], $_POST['hash1'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Missing credentials'
    ]);
    exit;
}

$uname = trim($_POST['hash']);
$pwd   = trim($_POST['hash1']);

if ($uname === '' || $pwd === '') {
    echo json_encode([
        'success' => false,
        'error' => 'Empty credentials'
    ]);
    exit;
}


		$EncTok = md5(getNum());





$sql = "SELECT user_id, password, user_type_id, department
        FROM web_users
        WHERE status='Active'
          AND current_status='Active'
          AND SHA2(uname,256)=?";

$conn = db_connect();

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uname);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();

// var_dump($rs);
// if (!$rs || empty($rs['count'])) {
//     echo json_encode([
//         'success' => false,
//         'error' => 'User not found' . var_dump($params)
//     ]);
//     exit;
// }

// var_dump($row);

        $rand = md5(getNum());


$_SESSION['userid']     = $row['user_id'];
$_SESSION['user_type']  = $row['user_type_id'] ?? 0;
$_SESSION['department'] = $row['department'];
$_SESSION['web_user']   = true;

		$_SESSION['loginid'] = $rand;
		$_SESSION['Ologinid'] = $rand;
        

		if (!defined('CPATH')) define('CPATH', '/');
		setcookie("ses", $rand, getCookieParam());
		setcookie("sesid", session_id(), getCookieParam());

		$EncTok = md5(getNum());
		$si = getHostByName(getHostName());

		$_SESSION['EncTok'] = $EncTok;

        



echo json_encode([
    'success' => true,
    "redirect" => "main.php?EncHid=$EncTok"
], JSON_PRETTY_PRINT);



