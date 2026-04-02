<?php require_once "../conf/config.inc.php";
require_once ReturnPath(2) . "appcode/ForAjax.inc.php";
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();

// $str1 = "<option value='-1'>--- Select ---</option>";

$frmVal = array(
	"comp_notice_id|text|y|1|100000|num|Please enter Valid language !",
);
$ValiStr = implode('|$$|', $frmVal);
$FrmError = $chk->requestcheck($ValiStr, "frmmain", "div", true);
if ($FrmError[0]) {
	$result[0] = false;
	// $result[1]=$FrmError;
	goto ComeHere;
}
// $subQry = (isset($_REQUEST['mainView']) && $_REQUEST['mainView'] == true) ? ' and ls.parent_ls_id is null and ls.pos_id=4' : '';

$rs = $obj->simplefetch("select * from comp_notification where comp_notice_id=$_REQUEST[comp_notice_id] and status='Active'");
foreach ($rs[1] as $row) {}

$rs1=$obj->simplefetch("select * from school_groups where group_id in ($row[groups]) and status='Active'",1);
if($rs1[0]>0){
    foreach($rs1[1] as $row1){
        echo "<option value=".$row1['group_id'].">".$row1['group_name']."</option>";
    }
}

ComeHere:
echo $str1;