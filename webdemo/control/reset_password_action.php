<?php include '../appcode/globals.inc.php';
//include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
$obj->AjaxFilePrevent();
$result=array(0=>false);

if ($_ENV['CAPTCHA']=="true" && ($_SESSION['captcha_val1'] != $_REQUEST['T31'] || empty($_SESSION['captcha_val1']))) {
	$result[2] = array(true, 'Incorrect Security Code Entered !', 'alert-danger');
	goto ComeHere;
}
$_SESSION['captcha_val1'] = ''; #so refesh required denied

$frmVal=array(    
    "hash1|password|y|0|100|alnum_spc|hidein=T2|Please enter New Password !",
    "hash2|password|y|8|100|alnum_spc|hidein=T3|Please Enter New Password with atleast 8 characters. Password should be contain atlease 2 Special Characters, 2 Upper Case Aplhabets, 2 Lower Case Aplhabets, 2 Numeric Values !",
);    
$ValiStr=implode('|$$|',$frmVal);
$FrmError=$chk->requestcheck($ValiStr,"formLogin","div",true);
if($FrmError[0]){
    $result[0]=false;
    $result[1]=$FrmError;
    goto ComeHere;        
}
$_GET['param']=$_REQUEST['param'];
$obj->DecruptUrl();
$method="Reset Pass Link";

if($_REQUEST['hash1']===$_REQUEST['hash2']){

    $tab='web_users';
    $C1 = 'user_id';
    $C2 = 'my_val';            
    // $rs=$obj->fetchcols($tab,"user_id,uname,user_name,user_type_id","user_id=$_GET[uId] and current_status='Active'");
    $rs=$obj->simplefetch("select wu.user_id, wu.uname, concat(ifnull(uf.f_name,''),' ',ifnull(uf.m_name,''),' ',ifnull(uf.l_name,'')) as user_name, wu.user_type_id from web_users wu
INNER JOIN web_users_profile uf on uf.user_id=wu.user_id where wu.status='Active' and wu.status='Active' and wu.current_status='Active' and wu.user_id=$_GET[uId]",1);
    if($rs[0]<=0){        
        $result[2]=array(true,'Unable to complete your request, Please contact to Administrator!','alert-danger');
        goto ComeHere;
    }
    
    $PrePassNA=5;
    $pChk=$obj->getNameQry("select wp.logid from web_passlog wp 
INNER JOIN (SELECT logid from web_passlog WHERE user_id=$_GET[uId] ORDER BY logid DESC LIMIT $PrePassNA) wp1 on wp.logid=wp1.logid
where wp.`password`='$_REQUEST[hash1]'");
    if(!empty($pChk)){
        $result[2]=array(true,"New password should be diffrent form last $PrePassNA passwords!",'alert-info');
        goto ComeHere;
    }
    
    
    $success=$obj->simplefetchUA("update $tab set password='$_REQUEST[hash1]'/*,$C2='$NewPass[0]'*/,ip_addr='$_SERVER[REMOTE_ADDR]',my_val=NULL where status='Active' and current_status='Active' and $C1=$_GET[uId]");
    if($success)
    {
        $obj->simplefetchUA("insert into web_passlog (change_date,change_method,ip_addr,user_id,password) values (Now(),'$method','$_SERVER[REMOTE_ADDR]',$_GET[uId],'$_REQUEST[hash1]')");
        $obj->simplefetchUA("update web_forgot_pass_request set req_status=1,action_on=now(),action_ip='$_SERVER[REMOTE_ADDR]' where status='Active' and req_status=0 and pas_reset_id=$_GET[reqId]");
        
        if(!empty($rs[1][0]['uname']))
        {                
            $msg="Dear ".ucwords($rs[1][0]['user_name']).",<br/>Your password has been successfully changed. If you did not changed then contact to CHD administrator immediately.<br><br> Regards <br>NIC/NICSI<br>(National Informatics Centre)";
            $sub="Login Credential To Access CHDBHASHA Portal";
            $obj->sendmail(strtolower(trim($rs[1][0]['uname'])),$msg,$sub);
            // $obj->sendmail(strtolower(trim('sanjaykumar_comat@yahoo.com')), $msg, $sub);              
        }
        $result[0]=true;
        if($rs[1][0]['user_type_id']==4)
            $redPath = '../index.php';
        else
            $redPath = 'login.php';
        $obj->show_msg("Your Password has been changed!");
        $result[3]=array(true,$redPath);
    }
        
}

ComeHere:
echo $obj->frm_response($result);