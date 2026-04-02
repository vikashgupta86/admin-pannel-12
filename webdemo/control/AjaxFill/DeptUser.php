<?php require_once("../conf/config.inc.php");
require_once(ReturnPath(2)."appcode/ForAjax.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();

$str1="<option value='-1'>--- Select ---</option>";
$LeftJoin=$SubQry='';


$rs=$obj->simplefetch("SELECT * FROM `web_users` WHERE `status`='Active' and department='$_REQUEST[dep_id]'",1);


if($rs[0]>0){
    foreach($rs[1] as $row){        
        $str1 .="<option value='".$row['user_id']."' title='$row[uname]'>".($row['uname'])."</option>";
    }
}
echo $str1;