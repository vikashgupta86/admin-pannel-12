<?php namespace akiko_audit;
// session_name("CSTT");

(!in_array('ob_gzhandler', ob_list_handlers())) ? ob_start('ob_gzhandler') : ob_start(); /* initialize ob_gzhandler to send and compress data */
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); /* expiration header format */
//header('Cache-Control: no-store, no-cache, must-revalidate');
// header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header("x-frame-options: SAMEORIGIN");

interface audit {
	/**
	 *@description
	 *  Manually expire the client session
	 */
	public function chk_session_time();
	/**
	 *@description
	 *  Validate the value
	 */
	public function chkValue($secLevel, $DebugFlage);
	/**
	 *@description
	 *  destroy the user session
	 */
	public function ses_destory();
}

/**
 * security
 *
 * @package
 * @copyright dv-23
 * @version 1.0
 * @access public
 *
 *
 */
class security implements audit {
	var $AllowedTime = 6000; /*in seconds*/
	private $whiteList = '/^[0-9a-zA-Zs ]+$/mui';
	private $VALIDATE_QRYSTRING = '/^([0-9a-zA-Zs %=&_\-+\/])+$/mui';
	private $VALIDATE_GET = '/^([0-9a-zA-Zs _\-+\/=])+$/mui';
	private $VALIDATE_GET_COOKIE = '/^([0-9a-zA-Zs %=&_\-+\/])+$/mui';
	private $VALIDATE_POST = '/^([0-9a-zA-Zs \r\n!#@%&$"_+\-=\[\];:\\|,.\'\"\/?(){}])+$/mui';
	private $blackList = '/\b(?:script>|html>|injection|alert|iframe|select|sleep)\b/mui';#as per Mr.Gaurav "union|limit" removed
	//private $blackList_rtf = '/\b(?:script>|html>|injection|alert|select|sleep)\b/mui';
	private $blackList_rtf = '/\b(?:script>|html>|injection|alert|sleep)\b/mui';
	private $filter = "/~|!|@|<|>|html>|injection|alert|iframe|union|select|sleep|onmouseover|prompt|bad|\[|\]|\?|\{|\}|\(|\)|\"|-|;|'|\\'|,|\*|\\r|\\n/";

	private $vulFlage = true;
	private $error_string = NULL;
	private $unicode_flage = false;

	/**
	 * @package security Code
	 * @param level, 1=querystring, 2=get, 3=post, 4=cookie, 5=fils
	 * @uses set the user session timeout
	 *
	 */
	function __construct($level = NULL, $debug = false) {		
		try {
			$this->AllowedTime = $_ENV['ALLOWED_TIME'];
		} catch (Exception $e) {
			die($e->getMessage());
		}

		if(!empty($_SESSION['userid']))
			$this->chk_session_time();

		$this->unicode_flage = (isset($_GET['lang']) && in_array($_GET['lang'], array('hi_IN', '2')))?true:false;

		$this->chkValue($level, $debug);

		if (!$this->vulFlage) {
			if ($debug=="true") {
				die('<br><br>Vulnability Found!');
			}
			$this->ses_destory();
		} else {
			#echo '>>Looks Gud';
		}
	}

	private function redirectHeader() {

		if ($_ENV['LOG_ENABLE']=="true") {
			$file = __DIR__ . '/../WriteReadData/security.log';
			$stringData = 'IP:' . $_SERVER['REMOTE_ADDR'] . '  SN:' . $_SERVER['SCRIPT_NAME'] . '  QS:' . $_SERVER['QUERY_STRING'];
			/*foreach($_SERVER as $s =>$sVal){
				                $stringData.=$s.':'.$sVal.'    '.PHP_EOL;
			*/
		}
		if (preg_match("/control/i", $_SERVER['SCRIPT_NAME']) == false) {
			#echo '<pre>';print_r($_SERVER);
			#die('aaaa');
			$redirectPage = "Location:index1.php" . (!empty($_SESSION['lang']) ? "?lang=$_SESSION[lang]" : '');
		} else if (session_id() !== '' && !empty($_SESSION['EncTok'])) {
			$redirectPage = "Location:../control/main.php?EncHid=$_SESSION[EncTok]";
		} else {
			$redirectPage = "Location:login.php";
		}
		if ($_ENV['LOG_ENABLE']=="true") {
			file_put_contents($file, strftime('%Y-%m-%d %H:%M:%S') . ' ' . $stringData . '  RDP:' . $redirectPage . PHP_EOL, FILE_APPEND);
		}

		if (preg_match("/CustomError/i", $_SERVER['SCRIPT_NAME']) == false) {
			header($redirectPage);
			exit();
		}
	}

	/**
	 * @package security Code
	 * @uses set the user session timeout
	 *
	 */
	function chk_session_time() {
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $this->AllowedTime)) {
			$this->ses_destory();
		}
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	}

	/**
	 * @package security Code
	 * @uses checking the sql injection in the values
	 *
	 */
	function chkValue($level, $debug) {
		switch ($level) {
		case 1:
			###validate QueryString
			$this->ValidQry($debug);
			break;
		case 2:
			###validate GET
			$this->ValidGet($debug);
			break;
		case 3:
			###validate post
			$this->ValidPost($debug);
			break;
		case 4:
			###validate cookie
			$this->ValidCookie($debug);
			break;
		case 5:
			###validate file
			$this->ValidFile($debug);
			break;
		case 6:
			$this->validHost($debug);
			break;
		default:
			$this->validHost($debug);
			#for the query string
			if ($this->ValidQry($debug)) {
				###validate post
				$this->ValidPost($debug);

				###validate files
				$this->ValidFile($debug);

				###validate GET
				$this->ValidGet($debug);

				###validate COOKIE
				$this->ValidCookie($debug);
			}
			break;
		}
	}

	/**
	 * @package security Code
	 * @uses halt a sql injection if comming in Query string method
	 *
	 */
	private function ValidQry($debug) {


		if ($debug=="true") {
			echo "Val: $_SERVER[QUERY_STRING]";
		}


		
		if (!empty($_SERVER['QUERY_STRING'])) {

			$_SERVER['QUERY_STRING'] = preg_replace($this->filter, '', urldecode(strtolower($_SERVER['QUERY_STRING'])));



			if (($this->unicode_flage==false && !preg_match($this->VALIDATE_QRYSTRING, $_SERVER['QUERY_STRING'])) || preg_match($this->blackList, $_SERVER['QUERY_STRING'])==true) {


				$qsArr = explode(';', $_SERVER['QUERY_STRING']);
				if (!is_integer($qsArr[0]) && !in_array($qsArr[0], array('404', '500', '403'))) {
					/*if($_ENV['LOG_ENABLE']){
						                        $file = __DIR__.'/../WriteReadData/security.log';
						                        $stringData = '::QRV:: IP:'.$_SERVER['REMOTE_ADDR'].'  SN:'.$_SERVER['SCRIPT_NAME'].'  QS:'.$_SERVER['QUERY_STRING'];
						                        file_put_contents($file, strftime('%Y-%m-%d %H:%M:%S').' '.$stringData.PHP_EOL, FILE_APPEND);
					*/

					$this->vulFlage = false;
					if ($debug=="true") {
						echo "Q Key: $key <>Val: $value";
					}
				}
			}
		}
		return $this->vulFlage;
	}

	/**
	 * @package security Code
	 * @uses halt a sql injection if comming in GET method
	 *
	 */
	private function ValidGet($debug) {
		###validate GET
		if (count($_GET) > 0) {
			foreach ($_GET as $key => $value) {
				$value = preg_replace($this->filter, '', strtolower($value));
				$_GET[$key] = $value;

				if (!empty($value) && (($this->unicode_flage==false && !preg_match($this->VALIDATE_GET, $value)) || preg_match($this->blackList, $value)==true)) {
					$this->vulFlage = false;
					if ($debug=="true") {

						echo "G Key: $key <>Val: $value";
					}
					return;
				}
			}
		}
	}

	/**
	 * @package security Code
	 * @uses halt a sql injection if comming in POST method
	 *
	 */
	private function ValidPost($debug) {
		###validate post
		if (count($_POST) > 0) {
			foreach ($_POST as $key => $value) {
				if (!empty($value) && !is_array($value)) {
					$value = utf8_decode($value);
					if ($key != 'textarea2' && (!preg_match($this->VALIDATE_POST, $value) || preg_match($this->blackList, $value)==true)) {
						$this->vulFlage = false;
						if ($debug=="true") {
							echo "Key: $key <>Val: $value";
						}
						return;
					} elseif ($key == 'textarea2' && preg_match($this->blackList_rtf, $value)==true) {
						$this->vulFlage = false;
						if ($debug=="true") {
							echo "P Key: $key <>Val: $value";
						}
						return;
					}
				}				
			}
		}
	}

	/**
	 * @package security Code
	 * @uses halt a sql injection if comming in FILES method
	 *
	 */
	private function ValidFile($debug) {
		###validate files
		/*if(count($_FILES)>0){
	            foreach ($_FILES as $key =>$value){
	                if($_FILES[$fname]['tmp_name']!=''){
	                    if(!preg_match('/^[a-zA-Z0-9]+\.[a-z0-9]{3,4}$/i',$_FILES[$fname]['name'])) {

	                    }
	                }
	            }
*/
	}

	/**
	 * @package security Code
	 * @uses halt a host header attach
	 *
	 */
	private function validHost($debug) {

		$WhiteListHostsArr = explode(',', $_ENV['ALLOWED_HOSTS']);

		if (!in_array($_SERVER['SERVER_NAME'], $WhiteListHostsArr)) {
			header('HTTP/1.0 403 Forbidden', TRUE, 403);
			exit;
		}
	}

	/**
	 * @package security Code
	 * @uses halt a sql injection if comming in COOKIE method
	 *
	 */
	private function ValidCookie($debug) {
		###validate post
		if (count($_COOKIE) > 0) {
			foreach ($_COOKIE as $key => $value) {
				if (!preg_match($this->VALIDATE_GET_COOKIE, $value) || preg_match($this->blackList, $value)==true) {
					//$this->vulFlage = false;
					if ($debug=="true") {
						echo "C Key: $key <>Val: $value";
					}
					return;
				}
			}
		}
	}

	/**
	 * @package security Code
	 * @uses destroy the session
	 *
	 */
	function ses_destory() {
		if (preg_match("/control/i", $_SERVER['SCRIPT_NAME'])) {
			session_unset(); // unset $_SESSION variable for the run-time
			session_destroy(); // destroy session data in storage
		}
		else{
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		$this->redirectHeader();
	}
}

#$audit=new audit_chk();
?>