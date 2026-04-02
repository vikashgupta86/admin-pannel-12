<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result  = array(0 => false);
$success = false;

$frmType   = isset($_REQUEST['frmType']) ? (int)$_REQUEST['frmType'] : 0;
$module_id = isset($_REQUEST['module_id']) ? (int)$_REQUEST['module_id'] : 0;
$m_name    = isset($_REQUEST['m_name']) ? trim($_REQUEST['m_name']) : '';
$fa_icon   = isset($_REQUEST['fa_ico_name']) ? trim($_REQUEST['fa_ico_name']) : '';

if ($frmType !== 3) {

    $FielArr = array(
        'module_name' => $m_name,
        'fa_icon'     => $fa_icon,
        'entry_by'    => $_SESSION['userid'],
        'entry_date'  => date('Y-m-d H:i:s'),
    );
}

switch ($frmType) {

    case 1: // ADD

        if ($m_name == '') {
            $result[2] = array(true,'Module name is required!','alert-danger');
            echo frm_response($result);
            exit;
        }

        $ChkModule = getNameQry("
            SELECT module_id 
            FROM web_st_module 
            WHERE status='Active' 
            AND LOWER(TRIM(module_name)) = LOWER(TRIM('$m_name'))
        ");

        if (!empty($ChkModule)) {
            $result[2] = array(true,'Requested module already exist!','alert-info');
            echo frm_response($result);
            exit;
        }

        $insertRes = insert("web_st_module", $FielArr, 1);
        $success   = ($insertRes !== false);

        if($success){
            $result[2] = array(true,'Module added successfully!','alert-success');
        }

    break;


    case 2: // UPDATE

        if ($module_id <= 0) {
            $result[2] = array(true,'Invalid module ID!','alert-danger');
            echo frm_response($result);
            exit;
        }

        $success = update(
            "web_st_module",
            $FielArr,
            "module_id = $module_id",
            1
        );

        if($success){
            $result[2] = array(true,'Module updated successfully!','alert-success');
        }

    break;


    case 3: // DELETE

        if ($module_id <= 0) {
            $result[2] = array(true,'Invalid module ID!','alert-danger');
            echo frm_response($result);
            exit;
        }

        $success = update(
            "web_st_module",
            array("status" => "Deleted"),
            "module_id = $module_id"
        );

        if($success){
            $result[2] = array(true,'Module deleted successfully!','alert-success');
        }

    break;
}

if ($success) {
    $result[0] = true;
}

echo frm_response($result);