<?php include '../../appcode/globals.inc.php';
include_once(BASE_PATH .'/control/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();

$str1 = "<option value='-1'>--- Select ---</option>";

$frmVal = array(
	"lang_id|text|y|1|1|num|Please enter Valid language !",
	"type_id|text|n|1|1|num|Please enter Valid link type !",
);
$ValiStr = implode('|$$|', $frmVal);
$FrmError = $chk->requestcheck($ValiStr, "frmmain", "div", true);
if ($FrmError) {
	$result[0] = false;
	// $result[1]=$FrmError;
	//goto ComeHere;
}
$subQry = (isset($_REQUEST['mainView']) && $_REQUEST['mainView'] == true) ? ' and ls.parent_ls_id is null and ls.pos_id=4' : '';

$rs = simplefetch("select /*ls.ls_id,*/lf.lid,wlt.link_name from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id where wlt.`status`='Active' and lf.status='Active' and wlt.type_id = ".$_REQUEST['type_id']." and wlt.continuous_content!=1 $subQry and wlt.lang_id = ".$_REQUEST['lang_id']." ORDER BY wlt.link_name");
if ($rs[0] > 0) {
	foreach ($rs[1] as $row) {
		$str1 .= "<option value='" . $row['lid'] . "' title='$row[link_name]'>" . ($row['link_name']) . "</option>";
	}
}
//ComeHere:
echo $str1;