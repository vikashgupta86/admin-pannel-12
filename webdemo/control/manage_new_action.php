<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$queries = '';
if(isset($_REQUEST['nChk']) && $_REQUEST['nChk']>0){
    $mStr=implode(',',$_REQUEST['nChk']);
    $queries="update web_links_final lf
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
set lf.new_icon='0', lf.new_icon_date=NULL where lf.status='Active' and lf.new_icon='1' and lt.lang_id = ".$_REQUEST['lang_id']." and lf.lid not in(".$mStr.")|$$|";
    foreach($_REQUEST['nChk'] as $l=>$lVal){        
        $queries.="update web_links_final set new_icon='1',new_icon_date=now() where status='Active' and lid=".$lVal."|$$|";    
    }
}
else{
    $queries="update web_links_final lf
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
set lf.new_icon='0', lf.new_icon_date=NULL where lf.status='Active' and lf.new_icon='1' and lt.lang_id = ".$_REQUEST['lang_id']."|$$|";
}

if(!empty($queries)){
    $queries=str_ireplace(array("''","'NULL'"),"NULL",$queries);
    $success=batch_execute($queries);
}
    


if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);