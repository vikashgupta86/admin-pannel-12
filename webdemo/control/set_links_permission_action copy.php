<?php include '../appcode/globals.inc.php';
include_once(BASE_PATH. '/control/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$frmVal=array(
    "user_type_id|text|y|1|10|num|Please enter Valid value!",
    #"chk|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed.."
);    
$ValiStr=implode('|$$|',$frmVal);

$FrmError=$chk->requestcheck($ValiStr,"frmmain","div",true);
if($FrmError){    
    $result[0]=false;
    $result[1]=$FrmError;    
    goto ComeHere;        
}
if(count($_REQUEST['chk'])>0){
    $str=implode(',',$_REQUEST['chk']);
    $subQry=" and ls_id not in($str)";
}else{
    #$result[1]=array('true','chk' => Array ( 'frmmain','chk','div','Please enter Valid value!' ) );
    #goto ComeHere;
}                                
$queries="";
$user_type_id = (int)$_REQUEST['user_type_id'] ?? 0;
// $query.="update web_map_func_user_type set status='Deleted' where status='Active' and user_type_id=$_REQUEST[user_type_id] $subQry|$$|";
$queries.="update web_links_permission set status='Deleted' where status='Active' and user_id=$user_type_id $subQry|$$|";

if(count($_REQUEST['chk'])>0){                            
    foreach($_REQUEST['chk'] as $k=>$val){
        $queries.="insert into web_links_permission (user_id,ls_id,entry_by,entry_date,ip_addr) select $user_type_id,$val,$_SESSION[userid], CURRENT_TIMESTAMP,'$_SERVER[REMOTE_ADDR]' from web_links_permission where status='Active' and user_id=$user_type_id and ls_id=$val having count(*)=0|$$|";
    }                            
}

$success=batch_execute($queries);
if($success)
    $result[0]=true;

ComeHere:
echo frm_response($result);
?>