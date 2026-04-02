<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$frmVal=array(
    "user_type_id|text|y|1|10|num|Please enter Valid value!",
    #"chk|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed.."
);    
$ValiStr=implode('|$$|',$frmVal);

//$FrmError=$chk->requestcheck($ValiStr,"frmmain","div",true);
//if($FrmError[0]){    
//    $result[0]=false;
//    $result[1]=$FrmError;    
//    goto ComeHere;        
//}

$FrmError = $chk->requestcheck($ValiStr, "frmmain", "div", true);

// Check if it's an array AND if the first element indicates an error
if (is_array($FrmError) && isset($FrmError[0]) && $FrmError[0]) {    
    $result[0] = false;
    $result[1] = $FrmError;    
    goto ComeHere;        
}
if(count($_REQUEST['chk'])>0){
    $str=implode(',',$_REQUEST['chk']);
    $subQry=" and sub_module_id not in($str)";
}else{
    #$result[1]=array('true','chk' => Array ( 'frmmain','chk','div','Please enter Valid value!' ) );
    #goto ComeHere;
}                                
$query = ""; 

$query.="update web_map_func_user_type set status='Deleted' where status='Active' and user_type_id=$_REQUEST[user_type_id] $subQry|$$|";

if(count($_REQUEST['chk'])>0){                            
    foreach($_REQUEST['chk'] as $k=>$val){
        $query.="insert into web_map_func_user_type (user_type_id,sub_module_id,entry_by,entry_date,ip_addr) select $_REQUEST[user_type_id],$val,$_SESSION[userid],Now(),'$_SERVER[REMOTE_ADDR]' from web_map_func_user_type where status='Active' and user_type_id=$_REQUEST[user_type_id] and sub_module_id=$val having count(*)=0|$$|";
    }                            
}

$success=batch_execute($query);
if($success)
    $result[0]=true;

ComeHere:
echo frm_response($result);
?>