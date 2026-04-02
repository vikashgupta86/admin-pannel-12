<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$BArr=explode(',',$_REQUEST['mStr']);
                                        
$Pos=1;
foreach($BArr as $k=>$recVal){                                
    $query.="update web_st_module set pos=$Pos where status='Active' and module_id=$recVal|$$|";
    $Pos++;                       
}
$success=batch_connect_MYSQLi($query);
if($success)
    $result[0]=true;
    
ComeHere:
echo frm_response($result);
?>