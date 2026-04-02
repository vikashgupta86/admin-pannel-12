<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$frmVal=array(
        "module_id|text|y|1|10|num|Please enter Valid Module Name!",
    );    
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"frm","div",true);
    if($FrmError[0]){
        $result[0]=false;
        $result[2]='';
        goto ComeHere;        
    }


$BArr=explode(',',$_REQUEST['mStr']);
                                        
$Pos=1;
foreach($BArr as $k=>$recVal){                                
    $query.="update web_st_sub_module set pos=$Pos where status='Active' and module_id=$_REQUEST[module_id] and sub_module_id=$recVal|$$|";
    $Pos++;                       
}
$success=batch_connect_MYSQLi($query);
if($success)
    $result[0]=true;
    
ComeHere:
echo frm_response($result);
?>