<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
$query = "";   // Initialize here 
$subQry = "";  // Initialize here

$frmVal=array(
    "user_type_id|text|y|1|10|num|Please enter Valid value!",
    "chk|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed.."
);    
$ValiStr=implode('|$$|',$frmVal);
$FrmError=$chk->requestcheck($ValiStr,"frmmain","div",true);

//if($FrmError[0]){
if (is_array($FrmError) && isset($FrmError[0]) && $FrmError[0]) {       
    $result[0]=false;
    $result[1]=$FrmError;    
    goto ComeHere;        
}

//if(count($_REQUEST['chk'])>0){
if(isset($_REQUEST['chk']) && count($_REQUEST['chk']) > 0){    
    $str=implode(',',$_REQUEST['chk']);
    $subQry=" and per_type_id not in($str)";
}                              

$query.="update web_map_per_user_type set status='Deleted' where status='Active' and user_type_id=$_REQUEST[user_type_id] $subQry|$$|";

//if(count($_REQUEST['chk'])>0){
if(isset($_REQUEST['chk']) && count($_REQUEST['chk']) > 0){
    foreach($_REQUEST['chk'] as $k=>$val){
        $query.="insert into web_map_per_user_type (user_type_id,per_type_id,entry_by,entry_date,ip_addr) select $_REQUEST[user_type_id],$val,$_SESSION[userid],Now(),'$_SERVER[REMOTE_ADDR]' from web_map_per_user_type where status='Active' and user_type_id=$_REQUEST[user_type_id] and per_type_id=$val having count(*)=0|$$|";
    }                            
}

$success=batch_execute($query);
if($success)
    $result[0]=true;

ComeHere:
echo frm_response($result);
?>