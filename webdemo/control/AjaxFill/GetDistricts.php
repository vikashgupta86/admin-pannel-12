<?php require_once("../../appcode/globals.inc.php");
#   require_once(ReturnPath(2)."appcode/ForAjax.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();

$str1="<option value='-1'>--- Select ---</option>";
$rs=simplefetch("SELECT district_id,district_name FROM web_st_districts WHERE status='Active' and state_id=$_REQUEST[id] order by district_name asc");
if($rs[0]>0){
    foreach($rs[1] as $row){        
        $str1 .="<option value='".$row['district_id']."' title='$row[district_name]'>".($row['district_name'])."</option>";
    }
}
echo $str1;