<?php


function send_mail(
    string $to,
    string $message,
    string $subject,
    ?string $from = null,
    ?string $cc = null,
    ?string $bcc = null,
    ?string $fileField = null,
    ?array $base64Files = null
): bool {

    if (($_ENV['EMAIL_ACTIVE'] ?? 'false') !== 'true') {
        return false;
    }

    $from = $from ?? ($_ENV['FROM'] ?? 'no-reply@example.com');

    $headers = [];
    $headers[] = "From: {$from}";
    $headers[] = "Reply-To: {$from}";
    $headers[] = "MIME-Version: 1.0";

    if ($cc) {
        $headers[] = "Cc: {$cc}";
    }

    if ($bcc) {
        $headers[] = "Bcc: {$bcc}";
    }

    $boundary = '==Multipart_Boundary_x' . md5((string) time()) . 'x';
    $attachments = '';
    $hasAttachment = false;

    if ($fileField && isset($_FILES[$fileField]) && is_uploaded_file($_FILES[$fileField]['tmp_name'])) {

        $fileData = file_get_contents($_FILES[$fileField]['tmp_name']);
        $fileData = chunk_split(base64_encode($fileData));

        $attachments .= "--{$boundary}\r\n";
        $attachments .= "Content-Type: {$_FILES[$fileField]['type']}; name=\"{$_FILES[$fileField]['name']}\"\r\n";
        $attachments .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $attachments .= $fileData . "\r\n";

        $hasAttachment = true;
    }

    if (is_array($base64Files)) {
        foreach ($base64Files as $file) {

            if (!isset($file['data'], $file['ftype'], $file['fname'])) {
                continue;
            }

            $attachments .= "--{$boundary}\r\n";
            $attachments .= "Content-Type: {$file['ftype']}; name=\"{$file['fname']}\"\r\n";
            $attachments .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $attachments .= chunk_split($file['data']) . "\r\n";

            $hasAttachment = true;
        }
    }

    if ($hasAttachment) {

        $headers[] = "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

        $body  = "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=utf-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";
        $body .= $attachments;
        $body .= "--{$boundary}--";

    } else {

        $headers[] = "Content-Type: text/html; charset=utf-8";
        $body = $message;
    }

    return mail(
        $to,
        $subject,
        html_entity_decode($body),
        implode("\r\n", $headers)
    );
}



function soap_client(string $url, array $params, string $method, bool $useProxy = false)
{
    try {
        $options = [];

        if ($useProxy) {
            $options = [
                'proxy_host' => $_ENV['PHOST'] ?? '',
                'proxy_port' => $_ENV['PORT'] ?? ''
            ];
        }

        $client = new SoapClient($url, $options);

        return $client->__soapCall($method, [$params]);

    } catch (SoapFault $e) {
        throw new Exception('SOAP Error: ' . $e->getMessage());
    }
}





function send_sms(string $to, string $message): string|false
{
    if (($_ENV['SMS_ACTIVE'] ?? 'false') !== 'true') {
        return false;
    }

    $query = http_build_query([
        'username'  => $_ENV['USERNAME'] ?? '',
        'pin'       => $_ENV['PASSWORD'] ?? '',
        'message'   => $message,
        'mnumber'   => $to,
        'signature' => $_ENV['SENDER'] ?? ''
    ]);

    $url = 'http://smsgw.sms.gov.in/failsafe/HttpLink';

    return call_curl($url, $query);
}




function call_curl(string $url, ?string $params = null): string
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $params,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
    ]);

    $output = curl_exec($ch);

    if ($output === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception('Curl Error: ' . $error);
    }

    curl_close($ch);
    return $output;
}





function encrypt_data(string $plain): string|false
{
    return openssl_encrypt(
        $plain,
        'AES-256-CBC',
        $_ENV['AUTHKEY'] ?? '',
        0,
        $_ENV['AUTHIV'] ?? ''
    );
}

function decrypt_data(string $encrypted): array
{
    $decrypted = openssl_decrypt(
        $encrypted,
        'AES-256-CBC',
        $_ENV['AUTHKEY'] ?? '',
        0,
        $_ENV['AUTHIV'] ?? ''
    );

    if ($decrypted === false) {
        return [];
    }

    parse_str($decrypted, $result);
    return $result;
}





// function userAuthenticationPageLevel(): void {
//     if (empty($_SESSION['loginid'])) {
//         die("empty login session id, - usercontrol 5");

//     destroy_session();
//         redirect_front('index');
//     }

//     if (session_id() !== ($_COOKIE['sesid'] ?? '')) {
        
// //    echo session_id();
// echo "1";
//     die($_COOKIE['sessid'] ?? 'COOKIES NOT SET');
//         die("coklkie session id, - usercontrol 16");
//         destroy_session();
//         redirect_front('index');
//     }

//     if (($_ENV['MULTILOG'] ?? 'true') === 'false') {
//         $conn = db_connect();  
//         $sql = "SELECT user_id FROM web_users_csrf WHERE user_id = ? AND session_id = ?";
//         $stmt = $conn->prepare($sql);
//         if (!$stmt) {
//             destroy_session();
//             redirect_front('index');
//         }

//         $uid = (int)($_SESSION['userid'] ?? 0);
//         $sid = $_SESSION['loginid'];

//         $stmt->bind_param("is", $uid, $sid);
//         $stmt->execute();

//         $result = $stmt->get_result();

//         if (!$result || $result->num_rows === 0) {
//             $stmt->close();
//             destroy_session();
//             redirect_front('index');
//         }

//         $stmt->close();
//     }
// }





	function userAuthenticationPageLevel() {
		#SESSION erp_admin,erp_user,web_admin,web_user
		########Validate diffrent user
		$logUserType = (isset($_SESSION['erp_admin']) && $_SESSION['erp_admin'] == true ? '1' : (isset($_SESSION['erp_user']) && $_SESSION['erp_user'] == true ? 2 : (isset($_SESSION['web_admin']) && $_SESSION['web_admin'] == true ? '3' : (isset($_SESSION['web_user']) && $_SESSION['web_user'] == true ? '4' : '5'))));
		$SesDesFlage = false;
		switch ($logUserType) {
			case 1:
			if (isset($_SESSION['erp_user']) && $_SESSION['erp_user'] == true || isset($_SESSION['web_admin']) && $_SESSION['web_admin'] == true || (isset($_SESSION['web_user']) && $_SESSION['web_user'] == true)) {
				$SesDesFlage = true;
			}
			break;

			case 2:
			if (isset($_SESSION['erp_admin']) && $_SESSION['erp_admin'] == true || isset($_SESSION['web_admin']) && $_SESSION['web_admin'] == true || (isset($_SESSION['web_user']) && $_SESSION['web_user'] == true)) {
				$SesDesFlage = true;
			}
			break;

			case 3:
			if (isset($_SESSION['erp_admin']) && $_SESSION['erp_admin'] == true || isset($_SESSION['erp_user']) && $_SESSION['erp_user'] == true || (isset($_SESSION['web_user']) && $_SESSION['web_user'] == true)) {
				$SesDesFlage = true;
			}
			break;

			case 4:
			if (isset($_SESSION['erp_admin']) && $_SESSION['erp_admin'] == true || isset($_SESSION['erp_user']) && $_SESSION['erp_user'] == true || (isset($_SESSION['web_admin']) && $_SESSION['web_admin'] == true)) {
				$SesDesFlage = true;
			}
			break;
		}
		#############################

		if (!isset($_SESSION['loginid'])) {
			headersFront(base_url() . "/index", null);
		}
        
		if ($_ENV['MULTILOG'] == 'false') {
			if ($_SESSION['user_type'] == 0) {
				$table = 'web_users_csrf';
				$fieldName = 'user_id';
			} else {
				$table = 'web_users_csrf';
				$fieldName = 'user_id';
			}

			$rs = simplefetch("select $fieldName from $table where $fieldName=$_SESSION[userid] and session_id='$_SESSION[loginid]'");
			if ($rs[0] <= 0) {
				$SesDesFlage = true;
			}

			if ($SesDesFlage) {
				//session_destroy();
				$this->destorySeesion();
				$this->headersFront($this->BaseUrl() . "/index", null);
			}
		}
		//################################ Disable for multilogin Allowed End

	}








function userAuthenticationMainLevel(): void
{
    if (empty($_SESSION['EncTok']) || empty($_REQUEST['EncHid'])) {

    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "<br>";
    // var_dump($_REQUEST);
    // echo "</pre>";
    // die("either EncTok or EncHid is empty");
        destroy_session();
        redirect_front('page-refresh');
    }

    if ($_SESSION['EncTok'] !== $_REQUEST['EncHid']) {

    
    // die(" enctok and encid are not same");

        destroy_session();
        redirect_front('page-refresh');
    }

    userAuthenticationPageLevel();

    $newToken = bin2hex(random_bytes(32));

    if (($_ENV['MULTILOG'] ?? 'true') === 'false') {
        $conn = db_connect();
        $sql = "UPDATE web_users_csrf SET session_id = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            destroy_session();
            redirect_front('page-refresh');
        }

        $uid = (int)($_SESSION['userid'] ?? 0);

        $stmt->bind_param("si", $newToken, $uid);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['EncTok']  = $newToken;
    $_SESSION['loginid'] = $newToken;

    setcookie('ses', $newToken, [
        'expires'  => time() + 3600,
        'path'     => '/',
        'secure'   => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}





    function curPageName(bool $full = true): string {
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        $file = basename($script);
        return $full ? $file : str_replace('.php', '', $file);
    }


    function GetPermission($per_id = NULL) {
	    $Sqry = '';
		if (!empty($per_id)) {
		    $Sqry = "and per_id=$per_id";
		}
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "0") {
		    $rs = fetchcols("web_user_permission", "per_id,sub_module_id", "user_id=$_SESSION[userid] $Sqry");
			if ($rs[0] <= 0) {
			    $pagArray = array('login', 'logoff', 'change_password', 'resetpass', 'reset_password', 'resetpass_action', 'reset_password_action');
				$reqPage = trim(strtolower(curPageName(false)));
				/*
                    if(!in_array($reqPage,$pagArray)){
				        echo "<script>alert('Not a Valid \'User ID or Password\', or Invalid try to access a Web Page ! Please Contact to Administrator!');</script>";
			            $obj->headers($obj->BaseUrl()."/control/logoff",null);
				*/

                            echo "<script>
                    alert('Access denied! Not a valid \'User ID\' or Password or Invalid try to access a Web Page ! Please Contact to Administrator!'); 
                    location.replace('/');
                </script>";
            exit; 
			} else {
		    	foreach ($rs[1] as $row) {
		            if ($_SESSION['userid'] == 1 && $_SESSION['user_type'] == "0") {
            			$rs1 = fetchcols("web_st_permission_type", "per_type_id", NULL);
					} else {
					    $rs1 = fetchcols("web_user_permission_group", "per_action_id,per_type_id", "per_id=$row[per_id]");
					}

					if ($rs1[0] > 0) {
					    foreach ($rs1[1] as $row1) {
					        $PerStr[] = $row1['per_type_id'];
					    }
					}
				}
			}
		} else {
		    $rs1 = fetchcols("web_st_permission_type", "per_type_id", NULL);
			if ($rs1[0] > 0) {
			    foreach ($rs1[1] as $row1) {
				    $PerStr[] = $row1['per_type_id'];
				}
			}
		}
		return $PerStr;
	}


//     function GetPermission($per_id = NULL) {
//     $Sqry = '';
//     if (!empty($per_id)) {
//         $Sqry = "and per_id=$per_id";
//     }

//     if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "0") {
//         $rs = fetchcols("web_user_permission", "per_id,sub_module_id", "user_id=" . $_SESSION['userid'] . $Sqry);
//         if ($rs[0] <= 0) {
//             $pagArray = array('login', 'logoff', 'change_password', 'resetpass', 'reset_password', 'resetpass_action', 'reset_password_action');
//             $reqPage = trim(strtolower(curPageName(false)));
//             // if (!in_array($reqPage, $pagArray)) {
//             //     echo "<script>alert('Not a Valid \'User ID or Password\', or Invalid try to access a Web Page ! Please Contact to Administrator!');</script>";
//             //     $obj->headers($obj->BaseUrl()."/control/logoff", null);
//             // }
//             echo "<script>
//                     alert('Access denied! Not a valid \'User ID\' or Password or Invalid try to access a Web Page ! Please Contact to Administrator!'); 
//                     location.replace('/');
//                 </script>";
//             exit; 
//         } else {
//             foreach ($rs[1] as $row) {
//                 if ($_SESSION['userid'] == 1 && $_SESSION['user_type'] == "0") {
//                     $rs1 = fetchcols("web_st_permission_type", "per_type_id", NULL);
//                 } else {
//                     $rs1 = fetchcols("web_user_permission_group", "per_action_id,per_type_id", "per_id=$row[per_id]");
//                 }
//                 if ($rs1[0] > 0) {
//                     foreach ($rs1[1] as $row1) {
//                         $PerStr[] = $row1['per_type_id'];
//                     }
//                 }
//             }
//         }
//     } else {
//         $rs1 = fetchcols("web_st_permission_type", "per_type_id", NULL);
//         if ($rs1[0] > 0) {
//             foreach ($rs1[1] as $row1) {
//                 $PerStr[] = $row1['per_type_id'];
//             }
//         }
//     }
//     return $PerStr;
// }


    


    
function base_url(bool $withProtocol = true): string
{
    $https = ($_SERVER['HTTPS'] ?? '') !== 'off' && !empty($_SERVER['HTTPS']);
    $protocol = $https ? 'https' : 'http';

    $host = $_SERVER['HTTP_HOST'] ?? '';

    $path = $_ENV['WEBSHARE'] ?? '';

    if ($withProtocol) {
        return $path ? "$protocol://$host/$path" : "$protocol://$host";
    }

    return $path ? "$host/$path" : $host;
}





function redirect(string $page, ?string $param = null, ?string $msg = null): void
{
    unset($_SESSION['error_msg']);

    $base = base_url(true);

    $target = '';



    switch (strtolower($page)) {

        case 'message':
            if ($msg) {
                $_SESSION['error_msg'] = $msg;
            }
            $target = $base . "/message.php";
            if ($param) {
                $target .= "?id=" . urlencode($param);
            }
            break;

        case 'login':
            $target = $base . "/login.php";
            if ($param) {
                $target .= "?id=" . urlencode($param);
            }
            break;

        default:
            $target = $page . ".php";
            if ($param) {
                $target .= "?" . $param;
            }
    }

    if (!empty($_ENV['LOG_ENABLE'])) {
        $logFile = __DIR__ . '/../WriteReadData/security.log';

        $log = date('Y-m-d H:i:s') .
            ' IP:' . ($_SERVER['REMOTE_ADDR'] ?? '') .
            ' URI:' . ($_SERVER['REQUEST_URI'] ?? '') .
            ' RDP:' . $target . PHP_EOL;

        file_put_contents($logFile, $log, FILE_APPEND | LOCK_EX);
    }

    header("Location: {$target}");
    exit;
}



function pageRefresh(): bool
{
    $page = curPageName(false);
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    $current = hash('sha256', $page . ($_REQUEST['EncHid'] ?? '') . $agent);

    if (!empty($_SESSION['curFlage']) && $_SESSION['curFlage'] === $current) {
        return true;
    }

    $_SESSION['curFlage'] = hash('sha256', $page . ($_SESSION['EncTok'] ?? '') . $agent);
    return false;
}





function redirect_front(string $page, ?string $param = null): void
{
    $lang = $_SESSION['lang'] ?? 'en';

    switch (strtolower($page)) {
        case 'message':
            $target = "message.php?id=" . urlencode((string)$param) . "&lang={$lang}";
            break;

        case 'message_close':
            $target = "message_close.php?id=" . urlencode((string)$param) . "&lang={$lang}";
            break;

        default:
            $target = $page . ".php?lang={$lang}";
            if ($param !== null) {
                $target = $page . ".php?" . $param . "&lang={$lang}";
            }
    }

    header("Location: {$target}");
    exit;
}






function build_encrypted_url(?string $query = null): string
{
    if ($query === null) {
        $query = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY) ?? '';
        $query = remove_url_param('param', $query);
    }

    $extra = http_build_query([
        'per_id' => $_REQUEST['per_id'] ?? '',
        'EncHid' => $_SESSION['EncTok'] ?? ''
    ]);

    $query = $query ? $query . '&' . $extra : $extra;

    $encrypted = encrypt_data($query);

    return $encrypted ? '?param=' . $encrypted : '';
}

