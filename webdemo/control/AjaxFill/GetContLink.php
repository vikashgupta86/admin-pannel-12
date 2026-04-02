<?php // require_once("../conf/config.inc.php");
//require_once(ReturnPath(2)."appcode/ForAjax.inc.php");

include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();

$str1="<option value='-1'>--- Select ---</option>";
$LeftJoin=$SubQry='';
if(isset($_POST['h_cont']) && $_POST['h_cont']==1){
    $LeftJoin="LEFT JOIN (SELECT wlt1.link_temp_id,wlt1.lid,wlt1.main_link_temp_id from web_link_temp wlt1 
                where wlt1.`status`='Active' and wlt1.type_id=3 and wlt1.continuous_content=1 and wlt1.lang_id=$_REQUEST[lang_id] and (wlt1.app_reject!=2 || wlt1.app_reject is null) and wlt1.publish_by is null) wlc on wlc.main_link_temp_id=lf.lid ";
    $SubQry=" and wlc.link_temp_id is not null";
}
elseif(isset($_POST['h_cont']) && $_POST['h_cont']==2){
    $LeftJoin="INNER JOIN (SELECT wlt1.link_temp_id,wlt1.lid,wlt1.main_link_temp_id from web_link_temp wlt1 
                where wlt1.`status`='Active' and wlt1.type_id=3 and wlt1.continuous_content=1 and wlt1.lang_id=$_REQUEST[lang_id] and wlt1.app_reject=1 and wlt1.publish_by is not null group by main_link_temp_id) wlc on wlc.main_link_temp_id=lf.lid ";
    
}
$rs=simplefetch("select lf.lid,wlt.link_name from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
$LeftJoin
where wlt.`status`='Active' and wlt.type_id=3 and wlt.continuous_content!=1 and wlt.lang_id=$_REQUEST[lang_id] $SubQry ORDER BY wlt.link_name");
if($rs[0]>0){
    foreach($rs[1] as $row){        
        $str1 .="<option value='".$row['lid']."' title='$row[link_name]'>".($row['link_name'])."</option>";
    }
}
echo $str1;