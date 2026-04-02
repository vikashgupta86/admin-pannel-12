<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);




//$matchHash =  md5($_REQUEST['hash3'].$_REQUEST['hash1']);


    $frmVal=array(
        "hash|password|y|8|100|alnum|hidein1=T1|Please enter Password !",
        "hash1|password|y|8|100|alnum|neelmnt=T1|hidein1=T2|Please Enter New Password with atleast 8 characters. Password should contain 2 Special Characters, 2 Upper Case Aplhabets and 2 Numeric Values !",
        "hash3|password|y|8|100|alnum|hidein1=T3|Please Enter Confirm Password !"
    ); 


   //  if($_REQUEST['hash'] === $matchHash)
   // {
   //      $result[0]=false;
   //      $result[2]=array(true,'New Password could not be same as Old Password','alert-danger');
   //      goto ComeHere;
    
   // }
      
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"frmmain","div",true);
    
    if($FrmError)
    {
        $result[0]=false;
        $result[1]=$FrmError;
       // goto ComeHere;        
    }
    
    $ChkUser = getName("web_users","password","user_id= ".$_SESSION['userid']." and user_type_id!=7 AND user_type_id = ".$_SESSION['user_type']."");
    if(empty($ChkUser))
        {
        session_destroy();                
        $result[0]=false;
        $result[2]=array(true,'Unauthorised access detected! Re-login and try again!','alert-danger');
       // goto ComeHere;
    }


    if($ChkUser!=$_REQUEST['hash'])
    {
        $result[2]=array(true,'Please Fill Correct Current Password Try again!','alert-info');
       // goto ComeHere;
    }   


    $PrePassNA=5;
    $pChk = getNameQry("select wp.logid from web_passlog wp INNER JOIN (SELECT logid from web_passlog WHERE user_id = ".$_SESSION['userid']." ORDER BY logid DESC LIMIT $PrePassNA) wp1 on wp.logid=wp1.logid where wp.`password`= ".$_REQUEST['hash1']."");
    if(!empty($pChk))
    {
        $result[2]=array(true,"New password should be diffrent form last $PrePassNA passwords!",'alert-info');
      //  goto ComeHere;
    }

    $method = "NORMAL";
    
   // if(md5($_REQUEST['hash3'].$ChkUser)===$_REQUEST['hash'] && $_REQUEST['hash1']===$_REQUEST['hash2']){
    if($_REQUEST['hash1']===$_REQUEST['hash2'])
    {
        // $success = simplefetch("update web_users set password = ".$_REQUEST['hash1'].", entry_date= ?, ip_addr = ".$_SERVER['REMOTE_ADDR'].", my_val = NULL where status='Active' and user_id = ".$_SESSION['userid']."");

        $uid = $_SESSION['userid'];
        $cdate = date('Y-m-d H:i:s');
        $updatetndrcat = "UPDATE web_users SET password = ?, entry_date = ?, ip_addr = ?, my_val = ? WHERE user_id = ? ";
        $success = simplefetchUA($updatetndrcat, "ssssi", [$_REQUEST['hash1'], $cdate, $_SERVER['REMOTE_ADDR'], null, $uid]);

        if($success)
        {
            $FielArr=array(
                'change_date' => date('Y-m-d H:i:s'),
                'change_method' => $method,
                'ip_addr' => $_SERVER['REMOTE_ADDR'],
                'user_id' => $_SESSION['userid'],
                'password' => $_REQUEST['hash1'],
            );

            $success = insert("web_passlog", $FielArr, 1);   
            $result[0]=true;

            // simplefetch("insert into web_passlog (change_date,change_method,ip_addr,user_id,password) values (Now(),'$method','$_SERVER[REMOTE_ADDR]',$_SESSION[userid],'$_REQUEST[hash1]')");
            // $result[0]=true;
        }
        
        //$rs = $obj->fetchtable("web_users","user_id=$_SESSION[userid] and user_type_id!=7 AND user_type_id = $_SESSION[user_type]");        
       // if(!empty($rs[1][0]['uname'])){                
            //$msg="Dear ".ucwords($rs[1][0]['user_name']).",<br/>Your password has been successfully changed. If you did not changed then contact to NMNH administrator immediately.<br><br> Regards <br>NIC/NICSI<br>(National Informatics Centre)";
           // $sub="Login Credential To Access NMNH Portal";
            //$obj->sendmail(strtolower(trim($rs[1][0]['uname'])),$msg,$sub);              
        //}
            
    }
    
//ComeHere:
echo frm_response($result);
?>