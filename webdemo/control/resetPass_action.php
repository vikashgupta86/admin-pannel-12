<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
//require_once("mailer/mail.php");

AjaxFilePrevent();
$result = array(0 => false);


if ($_ENV['CAPTCHA']=="true" && ($_SESSION['captcha_val1'] != $_REQUEST['T31'] || empty($_SESSION['captcha_val1']))) 
{
	$result[2] = array(true, 'Incorrect Security Code Entered !', 'alert-danger');
	//goto ComeHere;
	
}

$_SESSION['captcha_val1'] = ''; #so refesh required denied

// $frmVal = array(
// 	"P1|text|n|0|0|alnum|Please enter Username !",
// 	"hash3|text|y|0|100|alnum|hidein=P1|Please enter Login ID !",
// );
// $ValiStr = implode('|$$|', $frmVal);
// $FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true);
// if ($FrmError) 
// {
// 	$result[0] = false;
// 	$result[1] = $FrmError;
// 	//goto ComeHere;
// }

/*$UserID = $obj->getNameQry("select concat(wu.user_id,'|$$|',concat(ifnull(uf.f_name,''),' ',ifnull(uf.m_name,''),' ',ifnull(uf.l_name,'')),'|$$|',ifnull(wu.uname,''),'|$$|',ifnull(wu.user_type_id,''))as str from web_users wu
INNER JOIN web_users_profile uf on uf.user_id=wu.user_id where wu.status='Active' and wu.status='Active' and wu.current_status='Active' and wu.user_type_id!=4 and md5(wu.uname)='$_REQUEST[hash3]'",3);*/

$UserID = getNameQry("select concat(wu.user_id,'|$$|',concat(ifnull(uf.f_name,''),' ',ifnull(uf.m_name,''),' ',ifnull(uf.l_name,'')),'|$$|',ifnull(wu.uname,''),'|$$|',ifnull(wu.user_type_id,''))as str from web_users wu INNER JOIN web_users_profile uf on uf.user_id=wu.user_id where wu.status='Active' and wu.status='Active' and wu.current_status='Active' and wu.user_type_id!=4 and SHA2(wu.uname, 256) = ".$_REQUEST['hash3']."",1);

if (!empty($UserID)) 
{
	$UserID = explode('|$$|', $UserID);

	$FielArr = array(
		'user_type' => $UserID[3],
		'user_id' => $UserID[0],
		'request_on' => date('Y-m-d H:i:s'),
		'request_ip' => $_SERVER['REMOTE_ADDR'],
	);
	$_SESSION['userid'] = '0';
	
	$success = insert("web_forgot_pass_request", $FielArr, 1);


	if ($success) 
	{
		##############Email block######################
		$param = BindEncruptUrl("reqId=$success[0]&uId=$UserID[0]&reqOn=" . date('Y-m-d H:i:s'));
		//$RestUrl = BaseUrl() . '/control/reset_password.php' . $param;
		$RestUrl = BaseUrl() . '/control/reset_password.php' . $param;
		//$RestUrl = $obj->BaseUrl() . '/control/reset_password_link.php' . $param;


		$MsgBody = "<!DOCTYPE HTML>
					<html>
						<head>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" >
						</head>
						<body>
							Dear $UserID[1], <br><br>You recently requested to reset your password for your account. <a target=\"_blank\" href=\"$RestUrl\" title='Click Here to Reset the Password'>Click here</a> to reset it.<br><br>
							If you did not request a password reset, please ignore this email. This password reset is only valid for the next 30 minutes.
							<br><br> Regards <br>NIC/NICSI<br>(National Informatics Centre)
						</body>
					</html>";

		$sub = "Reset Password To Access Bee Portal";

		// $from = "kmanish8586@gmail.com"; // example: testemail@domain.com

		// $to = "kmanish1212@gmail.com"; // example: testemail@domain.com

		// $subject = " Text from PHP code through HostName";

		// $msg = " Login OTP  ";

		// $res = send_mail($from, $to, $subject, $msg);

		// if($res)
		// {
		//    echo " send mail result is ".$res;
		// }
		// else
		// {
		//   echo "Something went wrong. please try again.";
		// }
		
		$Mail = sendmail(strtolower(trim($UserID[2])), $MsgBody, $sub);
		// $Mail = $obj->sendmail(strtolower(trim('sanjaykumar_comat@yahoo.com')), $MsgBody, $sub);
		if ($Mail) 
		{
			$result[0] = true;
		}
		################################################
	}
}

if ($success) {
	
	$result[0] = true;
}

//ComeHere:
#print_r($result);
echo frm_response($result);