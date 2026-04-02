<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);

$user_type_id = $_REQUEST['user_type_id'] ?? 0;
$chkList = $_REQUEST['chk'] ?? [];

$frmVal = array(
    "user_type_id|text|y|1|10|num|Please enter Valid value!"
);

$ValiStr = implode('|$$|',$frmVal);

$FrmError = $chk->requestcheck($ValiStr, "frmmain", "div", true);

if (is_array($FrmError) && !empty($FrmError[0])) {
    $result[1] = $FrmError;
    echo frm_response($result);
    exit;
}

$subQry = "";

if (!empty($chkList)) {
    $str = implode(',', $chkList);
    $subQry = " AND sub_module_id NOT IN ($str)";
}

$query = "";

$query .= "UPDATE web_map_func_user_type 
           SET status='Deleted' 
           WHERE status='Active' 
           AND user_type_id=$user_type_id $subQry|$$|";

if (!empty($chkList)) {

    foreach ($chkList as $val) {

        $query .= "INSERT INTO web_map_func_user_type 
        (user_type_id,sub_module_id,entry_by,entry_date,ip_addr)
        SELECT $user_type_id,$val,{$_SESSION['userid']},NOW(),'{$_SERVER['REMOTE_ADDR']}'
        FROM web_map_func_user_type
        WHERE status='Active'
        AND user_type_id=$user_type_id
        AND sub_module_id=$val
        HAVING COUNT(*)=0|$$|";

    }

}

$success = batch_execute($query);

if ($success) {
    $result[0] = true;
}

echo frm_response($result);
?>