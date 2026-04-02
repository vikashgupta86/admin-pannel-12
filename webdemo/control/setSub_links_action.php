<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$queries='';
$pls_id=$_REQUEST['lsid'];
if(isset($_REQUEST['sChk']) && $_REQUEST['sChk']>0){
    $newLevel=$_REQUEST['level']+1;
    $sStr=implode(',',$_REQUEST['sChk']);
    
    $queries="update web_links_structure ls
INNER JOIN web_links_final lf on ls.lid=lf.lid
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
set ls.status='Deleted' where ls.status='Active' and lt.lang_id=$_REQUEST[lang_id] and ls.link_level=$newLevel and ls.parent_ls_id=$pls_id and lt.content_type=$_REQUEST[nmnh_type_id_sub] and lf.lid not in($sStr)|$$|";    

	
	foreach($_REQUEST['sChk'] as $l=>$lVal){        
        $lPos=$_REQUEST['pos_'.$lVal];
        
        $chrShow=isset($_REQUEST['chr_'.$lVal])?$_REQUEST['chr_'.$lVal]:'';
                
        $chkExist=getName("web_links_structure","ls_id","lid=$lVal and parent_ls_id=$pls_id and link_level=$newLevel");
        if(empty($chkExist)){            
            $queries.="insert into web_links_structure (show_char,lid,position,link_level,parent_ls_id,entry_by,entry_date,ip_addr) select '$chrShow','$lVal','$lPos','$newLevel','$pls_id','$_SESSION[userid]',now(),'$_SERVER[REMOTE_ADDR]' from web_links_structure where status='Active' and lid=$lVal and link_level=$newLevel and parent_ls_id=$pls_id having count(*)=0|$$|";
        }   
        else
            $queries.="UPDATE web_links_structure set show_char='$chrShow',position='$lPos',entry_by='$_SESSION[userid]',entry_date=now(),ip_addr='$_SERVER[REMOTE_ADDR]' where status='Active' and lid=$lVal and link_level=$newLevel|$$|";    
    }
}
else{
    $queries="update web_links_structure ls
INNER JOIN web_links_final lf on ls.lid=lf.lid
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
set ls.status='Deleted' where ls.status='Active' and lt.lang_id=$_REQUEST[lang_id] and lt.content_type=$_REQUEST[nmnh_type_id_sub] and ls.parent_ls_id=$pls_id|$$|";
}

if(!empty($queries))
{
    $queries=str_ireplace(array("''","'NULL'"),"NULL",$queries);
    $success=batch_execute($queries);
}
    


if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);