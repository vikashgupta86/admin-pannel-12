<?php
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = [0 => false];

$frmVal = [
    "user_id|text|y|1|10|num|Please enter Valid value!"
];

$ValiStr = implode('|$$|',$frmVal);

$FrmError = $chk->requestcheck($ValiStr,"frmmain","div",true);

if (is_array($FrmError) && !empty($FrmError[0])) {
    $result[2] = [true,'Invalid attempt to assign the Permission!','alert-info'];
    echo frm_response($result);
    exit;
}

$userId = (int)($_REQUEST['user_id'] ?? 0);

$SubFunc_id   = explode("|$$|", $_REQUEST['sub_SF_str'] ?? '');
$SubModule_id = explode("|$$|", $_REQUEST['sub_M_str'] ?? '');

$subStr = "";
$SubModuleArr = [];

foreach ($SubModule_id as $val2) {
    foreach ($SubFunc_id as $val) {
        if (isset($_REQUEST['chk'.$val2.'_'.$val])) {
            $subStr = $subStr === "" ? $val2 : $subStr.','.$val2;
            if (empty(${'SubFunc'.$val2})){ 
                ${'SubFunc'.$val2} = $val;
            } else {
                ${'SubFunc'.$val2} .= ','.$val;
            }
            $SubModuleArr[] = $val2;
            if (!is_numeric($val2) || strlen($val2) > 10) {
                $result[2] = [true,'Invalid Array Data Supplied!','alert-info'];
                echo frm_response($result);
                exit;
            }
        }
    }
}

if (!empty($subStr)) {
    $success = update("web_user_permission", ['status' => 'Deleted'], "sub_module_id not in($subStr) and user_id=$userId");
} else {
    $success = update("web_user_permission", ['status' => 'Deleted'], "user_id=$userId");
}

if (!empty($SubFunc_id)) {
    foreach ($SubModuleArr as $val2) {
        $SubChk = getName("web_user_permission", "per_id", "user_id=$userId and sub_module_id=$val2");
        if (empty($SubChk)) {
            insert("web_user_permission", ['user_id' => $userId, 'sub_module_id' => $val2]);

            $perId = getName("web_user_permission", "per_id", "user_id=$userId and sub_module_id=$val2");
            foreach ($SubFunc_id as $val) {
                if (isset($_REQUEST['chk'.$val2.'_'.$val])) {
                    insert("web_user_permission_group", ['per_id' => $perId, 'per_type_id' => $val]);
                }
            }
        } else {
            $perTypes = ${'SubFunc'.$val2} ?? '';
            if (!empty($perTypes)) {
                update("web_user_permission_group", ['status' => 'Deleted'], "per_type_id not in($perTypes) and per_id=$SubChk");
            } else {
                update("web_user_permission_group", ['status' => 'Deleted'], "per_id=$SubChk");
            }
            foreach ($SubFunc_id as $val) {
                if (isset($_REQUEST['chk'.$val2.'_'.$val])) {
                    $SubFuncChk = getName("web_user_permission_group", "per_action_id", "per_id=$SubChk and per_type_id=$val");
                    if (empty($SubFuncChk)) {
                        insert("web_user_permission_group", ['per_id' => $SubChk, 'per_type_id' => $val]);
                    }
                }
            }
        }
    }
}

if (!empty($success))
    $result[0] = true;

echo frm_response($result);