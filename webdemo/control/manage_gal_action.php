<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$queries='';
if(isset($_REQUEST['mChk']) && $_REQUEST['mChk']>0){
    $mStr=implode(',',$_REQUEST['mChk']);
    $queries.="update web_media_final mf
INNER JOIN web_media_temp mt on mt.m_temp_id=mf.m_temp_id
SET mf.gallery_flage=NULL,mf.entry_by='$_SESSION[userid]',mf.entry_date=now(),mf.ip_addr='$_SERVER[REMOTE_ADDR]'
where mf.status='Active' and mt.status='Active' and mt.m_cat_id=$_REQUEST[m_cat_id] and mf.m_id not in($mStr)|$$|";
    $queries.="update web_media_final set gallery_flage='1',entry_by='$_SESSION[userid]',entry_date=now(),ip_addr='$_SERVER[REMOTE_ADDR]' where status='Active' and m_id in($mStr)|$$|";
}
else{
    $queries="update web_media_final mf
INNER JOIN web_media_temp mt on mt.m_temp_id=mf.m_temp_id
SET mf.gallery_flage=NULL,mf.entry_by='$_SESSION[userid]',mf.entry_date=now(),mf.ip_addr='$_SERVER[REMOTE_ADDR]'
where mf.status='Active' and mt.status='Active' and mt.m_cat_id=$_REQUEST[m_cat_id]|$$|";
}

if(!empty($queries)){
    $queries=str_ireplace(array("''","'NULL'"),"NULL",$queries);
	
    $success=batch_execute($queries);
}
    


if($success)
    $result[0]=true;


echo frm_response($result);