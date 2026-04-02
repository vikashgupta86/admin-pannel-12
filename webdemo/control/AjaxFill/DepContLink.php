<?php require_once("../conf/config.inc.php");
require_once(ReturnPath(2)."appcode/ForAjax.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();

$str1="<option value='-1'>--- Select ---</option>";
$LeftJoin=$SubQry='';


$rs=$obj->simplefetch("select lf.lid,ifnull(date_format(lf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,lf.expiry_time,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
,concat(ru.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName,concat(pu.user_name,' [',date_format(lf.publish_date,'%M %d, %Y'),' ]')as pName from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
INNER JOIN web_users pu on pu.user_id=lf.publish_by
where wlt.`status`='Active' and lf.status='Active' and wlt.lang_id=$_REQUEST[lang_id] and wlt.continuous_content=0 and wlt.type_id=$_REQUEST[type_id] $usr_session order by link_name $LimitQry",1);


if($rs[0]>0){
    foreach($rs[1] as $row){        
        $str1 .="<option value='".$row['lid']."' title='$row[link_name]'>".($row['link_name'])."</option>";
    }
}
echo $str1;