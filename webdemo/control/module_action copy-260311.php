<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);
$success = false;

if (isset($_REQUEST['frmType']) && $_REQUEST['frmType'] != 3) {

    $Fman = $_REQUEST['frmType'] == 2 ? 'n' : 'y';

    $FielArr = array(
        'module_name' => $_REQUEST['m_name'],
        'fa_name' => $_REQUEST['fa_ico_name'],
        'entry_by' => $_SESSION['userid'],
        'entry_date' => date('Y-m-d H:i:s'),
    );


}

if (isset($_REQUEST['frmType'])) 
{
    switch ($_REQUEST['frmType']) {

    
        case 1: // Add

            $ChkModule=getNameQry("select module_id from web_st_module where status='Active' and lower(trim(module_name))=lower(trim('$_REQUEST[m_name]'))");

            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested module already exist!','alert-info');
                echo frm_response($result);
                exit;
            }

            $insertRes = insert("web_st_module", $FielArr, 1);
            $success = ($insertRes !== false);
            break;

        case 2: // Update
            
                $module_id = (int)$_REQUEST['module_id'];
                $success = update("web_st_module", $FielArr, "module_id = $module_id", 1 );
                break;

        case 3: // Delete
            //$success = delete("web_st_module", "module_id=" . $_REQUEST['module_id']);
            //break;
            $module_id = (int)$_REQUEST['module_id'];
            // Update status to Deleted instead of removing the row
            $success = update("web_st_module", array("status" => "Deleted"), "module_id=$module_id");
            break;
    }
}

if ($success) {
    $result[0] = true;
}

echo frm_response($result);

