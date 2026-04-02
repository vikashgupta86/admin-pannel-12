<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$queries='';
if(isset($_REQUEST['mChk']) && $_REQUEST['mChk']>0){
    //$mStr=implode(',',$_REQUEST['mChk']);
 foreach ($_REQUEST['mChk'] as  $mid) {
    	$m_id = $mid;

		/*$poss = !empty($_REQUEST['pos_'.$m_id])?$_REQUEST['pos_'.$m_id]:'NULL';
	
     $query.="update web_media_final mf SET mf.pos=$poss where mf.status='Active' and mf.m_id=$m_id |$$|";*/	
	
  if(isset($_REQUEST['pos_'.$m_id]) && $_REQUEST['pos_'.$m_id]!='' && is_numeric($_REQUEST['pos_'.$m_id]) )
   {
     $poss = $_REQUEST['pos_'.$m_id];
     $queries.="update web_media_final mf SET mf.pos=$poss where mf.status='Active' and mf.m_id=$m_id |$$|";
}
}
}
#print($query);
if(!empty($queries)){
	//die($query);
    $queries=str_ireplace(array("''","'NULL'"),"NULL",$queries);
    $success=batch_execute($queries);
}
    


if($success)
    $result[0]=true;

//ComeHere:
#print($result);
echo frm_response($result);