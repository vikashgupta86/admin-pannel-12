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

    if (!isset($_POST['hash_u'], $_POST['hash_p'], $_POST['hash_v'])) {
        echo json_encode(['success' => false, 'error' => 'Security validation failed']);
        exit;
    }

    $seed = $_SESSION['auth_seed'] ?? '';
    if (empty($seed)) {
        echo json_encode(['success' => false, 'error' => 'Session expired, please refresh']);
        exit;
    }

    $uname = decryptPayload($_POST['hash_u'], $seed);
    $pwd   = decryptPayload($_POST['hash_p'], $seed);
    $hash_v = $_POST['hash_v'];
    $enc_uname = md5(strtolower($uname));


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


//======================================================================================================================================
//================================================= |       CORE FUNCTIONS           | =================================================
//======================================================================================================================================
/*

    // #   GET LOCKOUT POLICY
    //     $getLockout = $obj->getNameQry("select count(sno) as tot from web_attempts where ipaddress='" . $ip . "' and DATE(dated) >= DATE_SUB(NOW(), INTERVAL 20 MINUTE);");
    // //  var_dump($getLockout);
    //     $getLockout = (int)$getLockout;
    //     if($getLockout >= 5){
    //         $response = [
    //             "0" => false,
    //             "2" => [true, "BLOCKED", "alert-danger"]
    //         ];
    //         echo json_encode($response, JSON_PRETTY_PRINT);
    //         die();
    //     } 



function IncCount($uid,$login,$ip,$uType){
    $cDate = date('Y-m-d H:i:s');
    $Response = array();
    $uid = ($uid === null) ? 'NULL' : "'".$uid."'";

    simplefetchUA("insert into web_attempts (login,ipaddress,pid,utype,dated) values('$login','$ip',$uid,'$uType','$cDate')");

    // echo $login;
    // echo "<br/>";
    // echo $ip;
    $TotRec = getNameQry("select count(sno) as tot from web_attempts where login='". $login . "' and ipaddress='" . $ip . "' and DATE(dated) = CURDATE();");
    $TotRec = (int)$TotRec;

    if($TotRec > 0){
        if(($TotRec) % 5 == 0){
            $NPass = $obj->generatePassword();
            // $userid = $obj->getName("web_users", "concat(user_id,'|$$|',user_name,'|$$|',uname)", "md5(username)='$login'");
            $userid = $obj->getNameQry("select concat(user_id,'|$$|',user_name,'|$$|',uname) as userid from web_users where md5(uname)='". $login . "';");
            // echo $login;
            // echo "----";
            //var_dump($userid);
            if(!empty($userid)){
                $userid = explode('|$$|',$userid);
                simplefetchUA("update web_users set password='$NPass[1]', ip_addr='$_SERVER[REMOTE_ADDR]' where status='Active' and user_id=$userid[0]");
                simplefetchUA("insert into app_passlog (change_date,change_method,ip_addr,user_id,user_type) values (Now(),'WRONG ATTEMPTS','$_SERVER[REMOTE_ADDR]',$userid[0],$uType)");
                $Response[0]= array(true,'Account locked. New password sent to email!','alert-info');
            } else {
                $Response[0]= array(true,'Incorrect UserName or Password Supplied ! (ERROR - 148)','alert-danger');
            }
        } else {
            //  echo "LN 123- " . ($TotRec) % 5 . "---";
            $Response[0]= array(true,'Incorrect UserName or Password Supplied ! (ERROR - 152)','alert-danger');
        }
    } else {
        $Response[0]= array(true,'Incorrect UserName or Password Supplied ! (ERROR - 156)','alert-danger');
    }
    return $Response;
}

*/






function logInEnter($id, $loginid, $userType, $ip) {
	global $obj;
	$cDate = curdatetime();
	simplefetchUA("insert into web_loginoroffusertrail (login,ipaddress,dateoflogoff,dateoflogin,userid,user_type_id) values ('$loginid','$ip','1970-01-01 00:00:00','$cDate','$id','$userType')");
}














//======================================================================================================================================
//================================================= |       CORE FUNCTIONS           | =================================================
//======================================================================================================================================





    $sql = "SELECT user_id, password, user_type_id, department, uname FROM web_users WHERE status='Active' AND current_status='Active' AND uname = ?";
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


    
//  $checkBlock = getNameQry("SELECT COUNT(*) FROM web_attempts WHERE login = '$enc_uname' AND ipaddress = '{$_SERVER['REMOTE_ADDR']}' AND DATE(dated) >= DATE_SUB(NOW(), INTERVAL 20 MINUTE)");
$checkBlock = getNameQry("SELECT COUNT(*) FROM web_attempts WHERE login = '$enc_uname' AND dated >= NOW() - INTERVAL 20 MINUTE;");
$checkBlock = (int)$checkBlock;

if($checkBlock >= 5)
{
    echo json_encode(['success' => false, 'error' => 'Too many failed attempts. Please try again later.']);
    exit;
}
// } else {
//     echo json_encode(['success' => false, 'error' => $checkBlock . ' Attempts. Please try again later.']);
//     exit;
// }


    $inputPwdHash = hash('sha256', $pwd);
    if ($inputPwdHash !== $user['password']) {

    $ipAddr = $_SERVER['REMOTE_ADDR'];
        simplefetchUA("insert into web_attempts (dated, ipaddress, login, pid, utype) values (CURRENT_TIMESTAMP, ?, ?, ?, ?)", "sssi", [$ipAddr, $enc_uname, $user['user_id'], $user['user_type_id']]);

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

	logInEnter($user['user_id'], $uname, $user['user_type_id'], $_SERVER['REMOTE_ADDR']);


    if (function_exists('csrf_get_tokens')) {
        csrf_get_tokens(); 
    }

    echo json_encode([
        'success' => true,
        "redirect" => "main.php?EncHid=$EncTok"
    ], JSON_PRETTY_PRINT);
