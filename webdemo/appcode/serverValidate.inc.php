<?php
/**
 * server Validation
 *
 * @package
 * @author akiko sherman infotech
 * @copyright dv-23
 * @version 2013
 * @access public
 *
 *
 */

class checks {
	private $VALIDATE_EMAIL = '/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
	private $VALIDATE_INZIPCODE = '/^\d{3}\s?\d{3}$/';
	private $VALIDATE_URL = '/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:~\+#]*[\w\-\@?^=%&amp;~\+#])?/';
	private $VALIDATE_INTEGER = '/^[0-9-]+$/';
	private $VALIDATE_FLOAT = '/^[0-9.]+$/';
	private $VALIDATE_ALPHA = '/^[a-zA-Zs]+$/';
	private $VALIDATE_ALPHA_S = '/^[a-zA-Zs ]+$/';
	private $VALIDATE_PASS = '/(?=^.{6,10}$)(?=.*\d{2,})(?=.*[a-z]{2,})(?=.*[A-Z]{2,})(?=.*[!@#$%^&amp;*()_+}{&quot;:;\'?/&gt;.&lt;,]{2,})(?!.*\s).*$/';
	private $VALIDATE_ALPHANUM = '/^[A-Za-z0-9\r\n]+$/';
	private $VALIDATE_ALPHANUM_S = '/^[A-Za-z0-9 \r\n\/]+$/';
	private $VALIDATE_ALPHANUM_SPC = '/^[a-zA-Z0-9 \r\n!@.-:$_#&,;?]+$/';
	private $VALIDATE_ALPHANUM_ASPC = '/^[a-zA-Z0-9 \r\n!@.-:$_#&,;?]+$/';
	private $VALIDATE_DATE = '/^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/';
	private $VALIDATE_TIME = '/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/';
	private $VALID_MIME_TYPES = array('.bmp' => array('image/bmp'), '.gif' => array('image/gif'), '.jpg' => array('image/jpeg', 'image/pjpeg'), '.jpeg' => array('image/jpeg', 'image/pjpeg'), '.pdf' => array('application/pdf', 'application/octet-stream'), '.png' => array('image/png', 'image/x-png'), '.zip' => array('application/zip'), '.doc' => array('application/msword'), '.xls' => array('application/vnd.ms-excel'), '.tif' => array('image/tiff'), '.docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document'), '.xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'), '.swf' => array('application/x-shockwave-flash'), '.flv' => array('flv-application/octet-stream'), '.csv' => array('application/vnd.ms-excel', 'text/comma-separated-values', 'text/csv', 'application/csv')); /*reconstruct array and subarrary because one extenstion can hava diffrent mime type*/
	// private $VALIDATE_NonASCII = '/[^\x{0900}-\x{097F}\x{0966}-\x{096F}]/u';
	private $VALIDATE_NonASCII = '/[^\x00-\x7F]+$/';
	private $VALIDATE_FILENAME = '/^[a-zA-Z0-9]+\.[a-z0-9]{3,4}$/i';
	private $HINDI_VAL = '/[^\x{0900}-\x{097F}a-zA-Z0-9 ]/u';


	//-------------------------------------------------------------------------------
	/**
	 * getFormType
	 * @package server Validation function
	 * @deprecated getting the form type of the form
	 *
	 * @return string Upload or Normal
	 *
	 */



	// function validateInput($str, $vType) {
	// 	if (preg_match($vType, $str) == false) {
	// 		//echo $str.'>>>'.$vType;
	// 		//exit;
	// 		return false;
	// 	} else {
	// 		return true;
	// 	}

	// }


	function checkInp($str, $vtype){
		if(preg_match($vtype, $str)){
			return true;
		}
		else{
			return false;
		}
	}
	
	// function checkLang($str, $vtype){
	// 	if(preg_replace($vtype,'', $str)){
	// 		return true;
	// 	}
	// 	else{
	// 		return false;
	// 	}
	// }

	function checkLang($str, $vtype){
		$l=preg_replace($vtype,'', $str);
        if($l==$str){
			return true;
		}
		else{
			return false;
		}
	}
	


	

	Function getFormType() {
		unset($ContentType);
		unset($formType);
		if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
			$ContentType = strtolower($_SERVER["HTTP_CONTENT_TYPE"]);
		} elseif (isset($_SERVER["CONTENT_TYPE"])) {
			$ContentType = strtolower($_SERVER["CONTENT_TYPE"]);
		}

		if (strstr($ContentType, 'multipart/form-data')) {
			$formType = 'Upload';
		} elseif (strstr($ContentType, 'application/x-www-form-urlencoded')) {
			$formType = 'Normal';
		} else {
			echo 'Invalid Form Type !';
			exit();
		}
	
		return $formType;
	}

	//-------------------------------------------------------------------------------
	/**
	 * todate
	 * @package usercon function
	 * @param date in the format DD/MM/YYYY
	 * @return date in the format YYYY-MM-DD
	 *
	 */

	function todate($datevar) {
		if (!strpos($datevar, '/')) {
			echo 'Invalid Date Format !';
			exit();
		}

		$date_split1 = explode("/", $datevar);
		$day = $date_split1[0];
		$month = $date_split1[1];
		$year = $date_split1[2];
		$date_format = $year . "-" . $month . "-" . $day;
		return $date_format;
	}

	//-------------------------------------------------------------------------------
	/**
	 * DateDifference
	 * @param from date format should be DD-MM-YYYY
	 * @param from date to should be DD-MM-YYYY
	 *
	 * @return bool value
	 */
	function DateDifference($F_date, $T_date) {
		if (!strpos($F_date, '/') && !strpos($T_date, '/')) {
			return false;
		}

		$F_date = date($this->todate($F_date));
		$T_date = date($this->todate($T_date));
		$date_diff = strtotime($T_date) - strtotime($F_date);
		if (($date_diff / (60 * 60 * 24)) > 0) // seconds into days
		{
			return false;
		} else {
			return true;
		}

	}

	//-------------------------------------------------------------------------------
	/**
	 * validateInput
	 * @package server Validation function
	 * @deprecated
	 * @param string as an email-id
	 * @return boolen value
	 *
	 */
	function CheckEmailDomain($rEmail) {
		if ($this->CheckInternet() == true) {
			list($username, $domain) = explode("@", $rEmail);
			if (getmxrr($domain, $mxrecords)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}

	}

	//-------------------------------------------------------------------------------
	/**
	 * validateInput
	 * @package server Validation function
	 * @deprecated
	 * @return string boolean value
	 *
	 */
	function CheckInternet() {
		$sCheckHost = 'www.google.com';
		return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	//-------------------------------------------------------------------------------

	



	//-------------------------------------------------------------------------------
	/**
	 * requestcheck
	 * @package server Validation function
	 * @deprecated
	 * y or n => field is required or optional
	 * alnum or alphanumeric => validate for alphabets and numbers
	 * alnum_s or alphanumeric_space => validate for alphabets and numbers with space
	 * alnum_spc or alphanumeric_spc => validate for alphabets and numbers with space and special character
	 * alnum_spcA or alphanumeric_spcA => validate for alphabets and numbers with space and special character, allow apostrophe
	 * num or numeric => validate for numbers only
	 * dec or decimal => validate for decimal value
	 * alpha or alphabetic => validate for alphabets only
	 * alpha_s or alphabetic_space => validate for alphabets with space
	 * email => validate for the email
	 * url => validate for the url
	 * lt or lessthan => means value should be less than
	 * gt or greaterthan => means value should be greater than
	 * dt => date check
	 * dtgtr => date should be greather than or equal
	 * dtltr => date should be less than or equal
	 * ti => time check 24 hours format
	 * dontselect =>any value which you dont want to select (for the dropdown case pass -1)
	 * dontselectchk =>
	 * shouldselchk =>
	 * selmin => atleast one checkbox should be selected
	 * selmax =>
	 * selone_radio => select atleast one radio
	 * eqelmnt => means request field value should be equal to another requested field
	 * neelmnt => means request field value should be not equal to another requested field
	 * ltelmnt =>
	 * leelmnt =>
	 * gtelmnt =>
	 * geelmnt =>
	 *
	 * @param validation String (field_name|field nature|field required or not|min length|max length|multiple validation as per requirement|error Msg)
	 * @param form name
	 * @param validation mode TD or DIV
	 * @return bool value
	 *
	 */
	function requestcheck($ValidationStr, $formName, $pType, $forAjax = false, $nonASCII = false) {
		$chkFlag = false;
		$retArr = $errArr = $errArr1 = array();
		//$errArr = array();
		//$errArr1 = array();
		$mainChkStr;
		$fieldType;
		$stringArr = explode("|$$|", $ValidationStr);

	


		//echo $this->getFormType();
		$FormType = is_null($formName) ? '' : $this->getFormType();

		//if ($this->getFormType()=='Normal'){/*Normal Form check start*/
		foreach ($stringArr as $v => $str) {
/*Individual field loop start*/
			unset($mainChkStr, $fieldReq, $fieldType);
			//unset($fieldReq);
			//unset($fieldType);
			#echo $str.'<br>';die;

			$fieldType = explode('|', $str);
			#print_r($fieldType);die;
			if (strtolower($fieldType[2]) == 'y' && strtolower($fieldType[1]) == 'file') {
				$fieldReq = 'req_file';
			} elseif (strtolower($fieldType[2]) == 'y' && strtolower($fieldType[1]) != 'file') {
				$fieldReq = 'req';
			}

			//echo $fieldReq;
			/*chk for the checkbox and listbox*/
			$fieldMnn = $MinVal = $MaxVal = '';

			if (strtolower($fieldType[1]) != 'checkbox' && strtolower($fieldType[1]) != 'listbox') {
				$MinVal = trim($fieldType[3]);
				if (is_numeric($MinVal)) {
					$fieldMnn = 'minlen=' . $MinVal;
				}

				$MaxVal = trim($fieldType[4]);
				if (is_numeric($MaxVal)) {
					$fieldMxn = 'maxlen=' . $MaxVal;
				}

			}

			unset($fieldErr);
			if (count($fieldType) > 0) {
				$fieldErr = end($fieldType);
			}

			$othChks = $msgName = '';
			//unset($msgName);

			foreach (array_slice($fieldType, 5, -1) as $mParam => $ParamVal) {
				$othChks .= "|$ParamVal";
				if (strstr($ParamVal, 'hidein=')) {
					$msgName = substr($ParamVal, 7);
				} elseif (strstr($ParamVal, 'file_extn=')) {
					$AllowExtns = explode(';', substr($ParamVal, 10));
				}

			}

# SAC ADDED 20260303
			$msgName = $msgName ?? '';
            $fieldReq = $fieldReq ?? '';
            $fieldMnn = $fieldMnn ?? '';
            $fieldMxn = $fieldMxn ?? '';
            $othChks = $othChks ?? '';
            $fieldErr = $fieldErr ?? '';
            



			$mainChkStr = "$msgName|~|$fieldReq|$fieldMnn|$fieldMxn$othChks|~|$fieldErr";
			//$mainChkStr;
			#echo '<br>'.$mainChkStr.'<br>';die;

			/**
			 * @deprecated Spilit new string into array
			 *
			 */
			unset($NewStrArr, $strFieldName, $strFieldChks, $strFieldMsg, $FieldValueArr);
			$NewStrArr = explode('|~|', $mainChkStr);
			//$strFieldName=$NewStrArr[0];
			$strFieldName = $fieldType[0];
			$strFieldChks = $NewStrArr[1];
			$strFieldMsg = $NewStrArr[2];

			/**
			 * @deprecated if Messag Name not Set then set it as Name of Field Name or Label Name
			 *
			 */
			if (empty($msgName)) {
				$msgName = $fieldType[0];
			}
			//echo 'Field Name:'.$strFieldChks.'<><><>';

			/**
			 *
			 * @deprecated spliting the Checks field and start the loop
			 */


			$FieldChkArr = explode('|', $strFieldChks);


			if (is_array($_REQUEST[$strFieldName] ?? '')) {
				$FieldValueArr = ($_REQUEST[$strFieldName]);
			} else {
				$FieldValue = trim($_REQUEST[$strFieldName] ?? '');
			}

			$FieldValue = ($FieldValue == 'undefined') ? '' : $FieldValue;
			/**
			 * @deprecated this chunk for the file section
			 *
			 */


			unset($FileName, $ext, $FileType, $FileSize, $file_sizeKb);
			// if (in_array('req_file', $FieldChkArr) == true || !empty($_FILES[$strFieldName]['name'])) {
			// 	/*foreach($_FILES[$strFieldName] as $k=>$val){
			// 		                            echo $k.'>>'.$val.'<br>';
			// 	*/

			// 	$FileName = $_FILES[$strFieldName]['name'];
			// 	$tmp = explode('.', strtolower($FileName));
			// 	$ext = end($tmp);
			// 	$FileType = $_FILES[$strFieldName]["type"];
			// 	$FileSize = $_FILES[$strFieldName]['size'];
			// 	$file_sizeKb = round($FileSize / 1024, 2);
			// 	/*print_r($AllowExtns);
			// 		                        echo $FileType;
			// 		                        print_r($this->VALID_MIME_TYPES['.'.$ext]);
			// 	*/

			// 	if (isset($_FILES[$strFieldName]['tmp_name'])) {
                    
            // // echo "<pre>";
            // // var_dump($_FILES);


			// 		// if (class_exists(@finfo)) {
			// 		// 	$file_info = new finfo(FILEINFO_MIME_TYPE);
			// 		// 	$FileType = $file_info->buffer(file_get_contents($_FILES[$strFieldName]['tmp_name']));
			// 		// }

            //             if (class_exists('finfo')) {
            //                 $file_info = new finfo(FILEINFO_MIME_TYPE);
            //                 $FileType = $file_info->buffer(file_get_contents($_FILES[$strFieldName]['tmp_name']));
            //             } else {
            //                 $FileType = mime_content_type($_FILES[$strFieldName]['tmp_name']);
            //             }
            //         }
			// }


if (
    (in_array('req_file', $FieldChkArr) == true && isset($_FILES[$strFieldName]) && $_FILES[$strFieldName]['error'] != UPLOAD_ERR_NO_FILE) 
    || 
    (!empty($_FILES[$strFieldName]['name']))
) {


    $FileName = $_FILES[$strFieldName]['name'];
    $tmp = explode('.', strtolower($FileName));
    $ext = end($tmp);


    $FileType = $_FILES[$strFieldName]["type"];
    $FileSize = $_FILES[$strFieldName]['size'];
    $file_sizeKb = round($FileSize / 1024, 2);


    if (isset($_FILES[$strFieldName]['tmp_name']) && $_FILES[$strFieldName]['tmp_name'] != '') {


        if (class_exists('finfo')) {
            $file_info = new finfo(FILEINFO_MIME_TYPE);
            $FileType = $file_info->file($_FILES[$strFieldName]['tmp_name']);
        } else {
            $FileType = mime_content_type($_FILES[$strFieldName]['tmp_name']);
        }


    }


}



			#print_r($FieldChkArr);
			foreach ($FieldChkArr as $fieldChk => $fieldChkVal) {
				//echo '<br>'.$fieldChkVal;
				unset($chkMsg, $chkType, $cmdValue, $temp);
				$reqFactr = false;

				if (in_array('req', $FieldChkArr) == true || in_array('req_file', $FieldChkArr) == true) {
					$reqFactr = true;
				}

				if ($reqFactr == true || (!empty($FieldValue) || !empty($FileName))) {
					if (strstr($fieldChkVal, '=')) {
						$temp = explode('=', $fieldChkVal);
						$chkType = $temp[0];
						$cmdValue = $temp[1];
					} else {
						$chkType = $fieldChkVal;
					}

				}

				/**
				 * @deprecated assign the Msg to chkMsg variable
				 *
				 */
				$chkMsg = $strFieldMsg;

				/**
				 * @deprecated checks case start for the validation
				 *
				 */
				#echo '<br>Field Name:'.$msgName.'<><><>Validatin Type:'.$chkType.'<><><>';


				
				switch ($chkType ?? '') {
				case 'req':
				case 'required':
					if (trim($FieldValue) == "") {
						if (!empty($FieldValueArr)) {
							foreach ($FieldValueArr as $ak => $aVal) {
								if (empty($aVal)) {
									$errArr1[$msgName] = "$msgName: $chkMsg";
									$chkFlag = true;
									break;
								}
							}
						} else {
							$errArr1[$msgName] = "$msgName: $chkMsg";
							$chkFlag = true;
						}
					}
					break;
				case 'maxlength':
				case 'maxlen':
					if (trim($FieldValue) != "" && strlen($FieldValue) > $cmdValue && empty($FileName)) {
						$errArr1[$msgName] = "$msgName: $chkMsg Length should not be greater than $cmdValue characters!";
						$chkFlag = true;
					}

					if (!empty($FileName) && $file_sizeKb > $cmdValue) {
#validation for the file
						$errArr1[$msgName] = "$msgName: File size should be less than $cmdValue KB";
						$chkFlag = true;
					}
					break;
				case 'rtf':
					if (!empty($FieldValue)) {
						
                        $FieldValue = clean_xss($FieldValue);
                        $_REQUEST[$strFieldName] = $FieldValue;
                        if (isset($_POST[$strFieldName])) {
                            $_POST[$strFieldName] = $FieldValue;
                        }
					}
					break;
				case 'minlength':
				case 'minlen':
					if (trim($FieldValue) != "" && strlen($FieldValue) < $cmdValue && empty($FileName)) {
						$errArr1[$msgName] = "$msgName: $chkMsg Minimum length should be $cmdValue digit!";
						$chkFlag = true;
					}
					if (!empty($FileName) && $file_sizeKb < $cmdValue) {
#validation for the file
						$errArr1[$msgName] = "$msgName: File size should be greater than $cmdValue KB";
						$chkFlag = true;
					}
					break;
				case 'alnum':
				case 'alphanumeric':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;	
				case 'alnum1':
				case 'alphanumeric1':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					
					break;
				case 'alnum_s':
				case 'alphanumeric_space':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_S) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alnum_spc':
				case 'alphanumeric_spc':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_SPC) == false) {
						if ($this->checkLang($FieldValue, $this->HINDI_VAL)== false)  {
							$errArr1[$msgName] = "$msgName: $chkMsg";
							$chkFlag = true;
	
						} 
					}
					break;
				
					// case 'hindi':
					// if ($this->checkLang($FieldValue, $this->HINDI_VAL)== false)  {
					// 	if ($this->checkLang($FieldValue, $this->HINDI_VAL)== false)  {
					// 		$errArr1[$msgName] = "$msgName: $chkMsg";
					// 		$chkFlag = true;
	
					// 	} 
					// } 
					// break;
				
					case 'alnum_spcA':
				case 'alphanumeric_spcA':

					if ($this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_ASPC)== false)  {
						if ($this->checkLang($FieldValue, $this->HINDI_VAL)== false)  {
							$errArr1[$msgName] = "$msgName: $chkMsg";
							$chkFlag = true;
	
						} 
						// $errArr1[$msgName] = "$msgName: $chkMsg";
						// $chkFlag = true;
					} 
					break;
				// case 'alnum_spcA':
				// case 'alphanumeric_spcA':
				// 	// exit(validateInput($FieldValue, $this->VALIDATE_INTEGER));

				// 	if (trim($FieldValue) != "" && validateInput($FieldValue, $this->VALIDATE_INTEGER) == true) {
				// 		$errArr1[$msgName] = "$msgName: $chkMsg";
				// 		$chkFlag = true;
				// 		exit($this->checkInp($FieldValue, $this->VALIDATE_INTEGER));
				// 	}
					
				// 	break;
				case 'num':
				case 'numeric':
					if (trim($FieldValue) != "" && $this->checkInp($FieldValue, $this->VALIDATE_INTEGER) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				
				// case 'rtf':					
				// 	$char1 = "html";
				// 	$char2 = "script";	
				// 	if (strpos(trim($FieldValue), $char1) !== false) {
				// 		$errArr1[$msgName] = "$msgName: $chkMsg";
				// 		$chkFlag = true;
				// 	} 
				// 	elseif (strpos(trim($FieldValue), $char2) !== false) {
				// 		$errArr1[$msgName] = "$msgName: $chkMsg";
				// 		$chkFlag = true;
				// 	} 
				// 	break;

				case 'dec':
				case 'decimal':
					$VALIDATE_DEC = '/^([0-9]{1,10}|[0-9]{1,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $VALIDATE_DEC) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alpha':
				case 'alphabetic':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHA) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alpha_s':
				case 'alphabetic_space':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHA_S) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'email':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_EMAIL) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					/*elseif(!empty($FieldValue) && $this->CheckEmailDomain($FieldValue)==false){
						                                    $errArr1[$msgName] = "$msgName: Invalid Email-ID!";
						                                    $chkFlag = true;
					*/
					break;
				case 'url':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_URL) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'lt':
				case 'lessthan':
					if ($FieldValue >= $cmdValue) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'gt':
				case 'greaterthan':
					if ($FieldValue <= $cmdValue) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dt':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_DATE) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dtgtr':
					if (!empty($FieldValue) && $this->DateDifference($FieldValue, $cmdValue) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dtltr':
					if (!empty($FieldValue) && $this->DateDifference($cmdValue, $FieldValue) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'ti':
				case 'time':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_TIME) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dontselect':
					if (!empty($FieldValue) && (!empty($FieldChkArr[0]) && $FieldValue == $cmdValue)) {
						if ($FieldValue == $cmdValue) {
							$errArr1[$msgName] = "$msgName: $chkMsg";
							$chkFlag = true;
						} elseif ($this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_S) == false) {
							$errArr1[$msgName] = "$msgName: Only Alphabets &amp; Numbers are Allowed !";
							$chkFlag = true;
						}
					}
					break;
				case 'dontselectchk':

					break;
				case 'shouldselchk':

					break;
				case 'selmin':
					$selCnt = 0;
					if (strtolower($fieldType[1]) == 'checkbox') {
						#echo $strFieldName;
						if (count($_REQUEST[$strFieldName]) > 0) {
							foreach ($_REQUEST[$strFieldName] as $k => $chk) {
								//echo $k."->".$chk;
								if ($this->checkInp($chk, $this->VALIDATE_ALPHANUM_S) == false) {
									//echo "i m here1";
									$errArr1[$msgName] = "$msgName" . "[]: Only Alphabets &amp; Numbers are Allowed !";
									$chkFlag = true;
									break;
								}
								if ($reqFactr == true) {
									$chkArr = explode('|', $str);
									$minLen = $chkArr[3];
									$maxLen = $chkArr[4];
									if (strlen($chk) < $minLen || strlen($chk) > $maxLen) {
										//echo "i m here2";
										// echo strlen($chk)."-".$minLen."-".$maxLen;
										$errArr1[$msgName] = "$msgName" . "[]: Invalid Length Entered !";
										$chkFlag = true;
										break;
									}
								}
								$selCnt++;
							}
						}

						if ($selCnt < $cmdValue) {
							//echo "i m here3";
							// echo $selCnt." ".$cmdValue."<br>";
							//exit();
							$errArr1[$msgName] = "$msgName" . "[]: Please Select Atleast $cmdValue Checkbox(s)!";
							$chkFlag = true;
							break;
						}
					} else {
						if ($this->checkInp($_REQUEST[$strFieldName], $this->VALIDATE_ALPHANUM_S) == false) {
							$errArr1[$msgName] = "$msgName" . ": Please Select Atleast $cmdValue Option!";
							$chkFlag = true;
							break;
						}
					}

				case 'selmax':

					break;
				case 'selone_radio':
				case 'selone':
					if ($reqFactr == true) {
						if (empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM) == false) {
							$errArr1[$msgName] = "$msgName: Please select one option from <i>$msgName</i> !";
							$chkFlag = true;
						}
					}
					break;
				case 'eqelmnt':
					if (empty($cmdValue)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> must Match !";
						$chkFlag = true;
					} elseif ($FieldValue != $cmdValue) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> must Match !";
						$chkFlag = true;
					}
					break;
				case 'neelmnt':
					if ($FieldValue == $cmdValue) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> must not Match !";
						$chkFlag = true;
					}
					break;
				case 'ltelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue >= $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Less than the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'leelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue > $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Less than or Equal to the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'gtelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue <= $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Greater than the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'geelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue < $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Greater than or Equal to the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'req_file':
					if ($FormType == 'Upload' && empty($FileName)) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'file_extn':
	// 				if ($FormType == 'Upload' && $reqFactr == true || $FormType == 'Upload' && !empty($FileName)) {


	// 					// print_r($AllowExtns);
    //   //                   echo "$ext  >> <br>";
    //   //                   echo $FileType.'<br>';
    //   //                   print_r($this->VALID_MIME_TYPES['.'.$ext]);exit;
						
	// 					if (!in_array($ext, $AllowExtns) || !in_array($FileType, $this->VALID_MIME_TYPES['.' . $ext])) {
	// 						$errArr1[$msgName] = "$msgName: $chkMsg";
	// 						$chkFlag = true;
	// 					}

	// 					if ($this->checkInp($FileName, $this->VALIDATE_FILENAME) == false) {
	// 						$chkMsg = 'Filename should not contain any special character and white space. Invalid Filename!';
	// 						$errArr1[$msgName] = "$msgName: $chkMsg";
	// 						$chkFlag = true;
	// 					}
	// 				}


$FileName = '';
$ext = '';
$FileType = '';
$FileSize = 0;
$file_sizeKb = 0;








if ($FormType == 'Upload' && ($reqFactr == true || !empty($FileName))) {

    if (!empty($ext) && isset($this->VALID_MIME_TYPES['.' . $ext])) {

        if (!in_array($ext, $AllowExtns) || !in_array($FileType, $this->VALID_MIME_TYPES['.' . $ext])) {
            $errArr1[$msgName] = "$msgName: $chkMsg";
            $chkFlag = true;
        }

    }

    if (!empty($FileName) && $this->checkInp($FileName, $this->VALIDATE_FILENAME) == false) {
        $chkMsg = 'Filename should not contain any special character and white space. Invalid Filename!';
        $errArr1[$msgName] = "$msgName: $chkMsg";
        $chkFlag = true;
    }

}





					break;

				} /*switch closed*/

			} /*checks loop closed*/
		} /*individual field loop end*/
		#die;
		$errArr[] = $errArr1;

		/*}/*Normal Form Check End*/
		/*else{

            }*/

		/**
		 * @deprecated assign a flage bool value and masg to the returning array
		 */
		$retArr[] = $chkFlag;
		$retArr[] = $errArr;

		if ($chkFlag == true) {
			$AjaxErrorArr[] = true;
			if ($forAjax) {
				foreach ($retArr[1] as $er => $error) {
					unset($TempEr);
					foreach ($error as $pr => $erPrint) {
						//echo $pr.'>>>'.$erPrint;
						//echo $formName.'>>>>'.$pType;
						$TempEr = explode(':', $erPrint);
						$TempEr[0] = str_replace('[]', '', $TempEr[0]);
						$ErrorArr[$TempEr[0]] = array($formName, $TempEr[0], $pType, $TempEr[1]);
					}
				}
				$AjaxErrorArr[] = $ErrorArr;
				return $AjaxErrorArr;
			} else {
				foreach ($retArr[1] as $er => $error) {
					unset($TempEr);
					foreach ($error as $pr => $erPrint) {
						//echo $pr.'>>>'.$erPrint;
						//echo $formName.'>>>>'.$pType;
						$TempEr = explode(':', $erPrint);
						echo "<script type='text/javascript'>$(document).ready(function() {createErrorSpace('$formName','$TempEr[0]','$pType','$TempEr[1]');});</script>";
					}
				}
			}
		}
		return $chkFlag;
	}

	//-------------------------------------------------------------------------------
	/**
	 * requestcheckQ
	 * @package server Validation function
	 * @deprecated
	 *
	 * @param validation String
	 * @param form name
	 * @return bool value
	 *
	 */
	function requestcheckQ($ValidationStr, $sendtoMsg = true) {
		$chkFlag = false;
		$retArr = $errArr = $errArr1 = array();
		//$errArr = array();
		//$errArr1 = array();
		$mainChkStr;
		$fieldType;
		$stringArr = explode("|$$|", $ValidationStr);

		foreach ($stringArr as $v => $str) {
/*Individual field loop start*/
			unset($mainChkStr, $fieldReq, $fieldType);
			//unset($fieldReq);
			//unset($fieldType);
			//echo $str.'<br>';

			$fieldType = explode('|', $str);
			if (strtolower($fieldType[2]) == 'y' && strtolower($fieldType[1]) == 'file') {
				$fieldReq = 'req_file';
			} elseif (strtolower($fieldType[2]) == 'y' && strtolower($fieldType[1]) != 'file') {
				$fieldReq = 'req';
			}

			/*chk for the checkbox and listbox*/
			$fieldMnn = $MinVal = $MaxVal = '';
			if (strtolower($fieldType[1]) != 'checkbox' && strtolower($fieldType[1]) != 'listbox') {
				$MinVal = trim($fieldType[3]);
				if (!is_numeric($MinVal)) {
					$fieldMnn = 'minlen=' . $MinVal;
				}

				$MaxVal = trim($fieldType[4]);
				if (!is_numeric($fieldType)) {
					$fieldMxn = 'maxlen=' . $MaxVal;
				}

			}

			unset($fieldErr);
			if (count($fieldType) > 0) {
				$fieldErr = end($fieldType);
			}

			$othChks = $msgName = '';
			//unset($msgName);

			foreach (array_slice($fieldType, 5, -1) as $mParam => $ParamVal) {
				$othChks .= "|$ParamVal";
				if (strstr($ParamVal, 'hidein=')) {
					$msgName = substr($ParamVal, 7);
				}

			}

			$mainChkStr = "$msgName|~|$fieldReq|$fieldMnn|$fieldMxn$othChks|~|$fieldErr";
			//echo $mainChkStr;
			//echo '<br>'.$str;

			/**
			 * @deprecated Spilit new string into array
			 *
			 */
			unset($NewStrArr, $strFieldName, $strFieldChks, $strFieldMsg);
			$NewStrArr = explode('|~|', $mainChkStr);
			//$strFieldName=$NewStrArr[0];
			$strFieldName = $fieldType[0];
			$strFieldChks = $NewStrArr[1];
			$strFieldMsg = $NewStrArr[2];

			/**
			 * @deprecated if Messag Name not Set then set it as Name of Field Name or Label Name
			 *
			 */
			if (empty($msgName)) {
				$msgName = $fieldType[0];
			}
			//echo 'Field Name:'.$strFieldName.'<><><>';

			/**
			 *
			 * @deprecated spliting the Checks field and start the loop
			 */
			$FieldChkArr = explode('|', $strFieldChks);
			$FieldValue = trim($_REQUEST[$strFieldName]);

			foreach ($FieldChkArr as $fieldChk => $fieldChkVal) {
				//echo '<br>'.$fieldChkVal;
				unset($chkMsg, $chkType, $cmdValue, $temp);
				$reqFactr = false;

				if (in_array('req', $FieldChkArr) == true || in_array('req_file', $FieldChkArr) == true) {
					$reqFactr = true;
				}

				if (strstr($fieldChkVal, '=')) {
					$temp = explode('=', $fieldChkVal);
					$chkType = $temp[0];
					$cmdValue = $temp[1];
				} else {
					$chkType = $fieldChkVal;
				}

				/**
				 * @deprecated assign the Msg to chkMsg variable
				 *
				 */
				$chkMsg = $strFieldMsg;

				/**
				 * @deprecated checks case start for the validation
				 *
				 */
				//echo '<br>Field Name:'.$msgName.'<><><>Validatin Type:'.$chkType.'<><><>';
				switch ($chkType) {
				case 'req':
				case 'required':
					if (trim($FieldValue) == "") {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'maxlength':
				case 'maxlen':
					if (trim($FieldValue) != "" && strlen($FieldValue) > $cmdValue) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'minlength':
				case 'minlen':
					if (trim($FieldValue) != "" && strlen($FieldValue) < $cmdValue) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alnum':
				case 'alphanumeric':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alnum_s':
				case 'alphanumeric_space':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_S) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alnum_spc':
				case 'alphanumeric_spc':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_SPC) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;

				case 'alnum_spcA':
				case 'alphanumeric_spcA':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_ASPC) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'num':
				case 'numeric':
					if (trim($FieldValue) != "" && $this->checkInp($FieldValue, $this->VALIDATE_INTEGER) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;

					}
					break;
				case 'dec':
				case 'decimal':
					$VALIDATE_DEC = '/^([0-9]{1,10}|[0-9]{1,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $VALIDATE_DEC) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alpha':
				case 'alphabetic':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHA) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'alpha_s':
				case 'alphabetic_space':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHA_S) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'email':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_EMAIL) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					} elseif (!empty($FieldValue) && $this->CheckEmailDomain($FieldValue) == false) {
						$errArr1[$msgName] = "$msgName: Invalid Email-ID!";
						$chkFlag = true;
					}
					break;
				case 'url':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_URL) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'lt':
				case 'lessthan':
					if ($FieldValue >= $cmdValue) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'gt':
				case 'greaterthan':
					if ($FieldValue <= $cmdValue) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dt':
					if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_DATE) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dtgtr':
					if (!empty($FieldValue) && $this->DateDifference($FieldValue, $cmdValue) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dtltr':
					if (!empty($FieldValue) && $this->DateDifference($cmdValue, $FieldValue) == false) {
						$errArr1[$msgName] = "$msgName: $chkMsg";
						$chkFlag = true;
					}
					break;
				case 'dontselect':
					if (!empty($FieldValue) && (!empty($FieldChkArr[0]) && $FieldValue == $cmdValue)) {
						if ($FieldValue == $cmdValue) {
							$errArr1[$msgName] = "$msgName: $chkMsg";
							$chkFlag = true;
						} elseif ($this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM_S) == false) {
							$errArr1[$msgName] = "$msgName: Only Alphabets &amp; Numbers are Allowed !";
							$chkFlag = true;
						}
					}
					break;
				case 'dontselectchk':

					break;
				case 'shouldselchk':

					break;
				case 'selmin':
					$selCnt = 0;
					if (strtolower($fieldType[1]) == 'checkbox') {
						//echo $strFieldName;
						foreach ($_REQUEST[$strFieldName] as $k => $chk) {
							//echo $k."->".$chk;
							if ($this->checkInp($chk, $this->VALIDATE_ALPHANUM_S) == false) {
								//echo "i m here1";
								$errArr1[$msgName] = "$msgName" . "[]: Only Alphabets &amp; Numbers are Allowed !";
								$chkFlag = true;
								break;
							}
							if ($reqFactr == true) {
								$chkArr = explode('|', $str);
								$minLen = $chkArr[3];
								$maxLen = $chkArr[4];
								if (strlen($chk) < $minLen || strlen($chk) > $maxLen) {
									//echo "i m here2";
									// echo strlen($chk)."-".$minLen."-".$maxLen;
									$errArr1[$msgName] = "$msgName" . "[]: Invalid Length Entered !";
									$chkFlag = true;
									break;
								}
							}
							$selCnt++;
						}
						if ($selCnt < $cmdValue) {
							//echo "i m here3";
							// echo $selCnt." ".$cmdValue."<br>";
							//exit();
							$errArr1[$msgName] = "$msgName" . "[]: Please Select Atleast $cmdValue Checkbox(s)!";
							$chkFlag = true;
							break;
						}
					} else {
						if ($this->checkInp($_REQUEST[$strFieldName], $this->VALIDATE_ALPHANUM_S) == false) {
							$errArr1[$msgName] = "$msgName" . ": Please Select Atleast $cmdValue Option!";
							$chkFlag = true;
							break;
						}
					}
					break;
				case 'selmax':

					break;
				case 'selone_radio':
				case 'selone':
					if ($reqFactr == true) {
						if (!empty($FieldValue) && $this->checkInp($FieldValue, $this->VALIDATE_ALPHANUM) == false) {
							$errArr1[$msgName] = "$msgName: Please select one option from <i>$msgName</i> !";
							$chkFlag = true;
						}
					}
					break;
				case 'eqelmnt':
					if (empty($cmdValue)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> must Match !";
						$chkFlag = true;
					} elseif ($FieldValue != $cmdValue) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> must Match !";
						$chkFlag = true;
					}
					break;
				case 'neelmnt':
					if ($FieldValue == $cmdValue) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> must not Match !";
						$chkFlag = true;
					}
					break;
				case 'ltelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue >= $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Less than the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'leelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue > $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Less than or Equal to the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'gtelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue <= $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Greater than the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;
				case 'geelmnt':
					unset($VALIDATE_DEC);
					$VALIDATE_DEC = '/^([0-9]{0,10}|[0-9]{0,10}\.[0-9]{0,' . $cmdValue . '})$/';
					if (!empty($FieldValue) && ($this->checkInp($FieldValue, $VALIDATE_DEC) == false || $this->checkInp($FieldValue, $cmdValue) == false)) {
						$errArr1[$msgName] = "$msgName: Data in Fields <i>$chkMsg</i> and <i>$cmdValue</i> should be Numeric !";
						$chkFlag = true;
					} elseif ($FieldValue < $cmdValue) {
						$errArr1[$msgName] = "$msgName: Value in Field <i>$chkMsg</i> must be Greater than or Equal to the Value of <i>$cmdValue</i> !";
						$chkFlag = true;
					}
					break;

				} /*switch closed*/

			} /*checks loop closed*/
		} /*individual field loop end*/

		$errArr[] = $errArr1;

		/**
		 * @deprecated assign a flage bool value and masg to the returning array
		 */
		$retArr[] = $chkFlag;
		$retArr[] = $errArr;

		if ($chkFlag == true && $sendtoMsg == true) {
			foreach ($retArr[1] as $er => $error) {
				unset($TempEr);
				foreach ($error as $pr => $erPrint) {
					//echo $pr.'>>>'.$erPrint;
					$TempEr = explode(':', $erPrint);
					$_SESSION['error_msg'] = $TempEr[1];
					//echo "<script type='text/javascript'>createErrorSpace('$formName','$pr','$pType','$TempEr[1]');</script>";
				}
			}
			header('Location: message.php?EncHid=' . $_SESSION['EncTok']);die();
		}
		return $chkFlag;
	}
}
?>  