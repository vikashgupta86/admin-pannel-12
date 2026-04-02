<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);
$success = false;

try {

    if (!isset($_REQUEST['frmType'])) {
        throw new Exception('Invalid request type.');
    }

    $frmType = (int)$_REQUEST['frmType'];

    $dash_cat_id   = isset($_REQUEST['dash_cat_id']) ? $_REQUEST['dash_cat_id'] : '';
    $year_id   = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
    $prog_name     = isset($_REQUEST['prog_name']) ? trim($_REQUEST['prog_name']) : '';
    $prog_name_h   = isset($_REQUEST['prog_name_h']) ? trim($_REQUEST['prog_name_h']) : '';
    $value_type    = isset($_REQUEST['value_type']) ? trim($_REQUEST['value_type']) : '';
    $value_type_h  = isset($_REQUEST['value_type_h']) ? trim($_REQUEST['value_type_h']) : '';
    $value_num     = isset($_REQUEST['value_num']) ? $_REQUEST['value_num'] : '';

    $Fman  = $frmType == 2 ? 'n' : 'y';
    $Fman1 = $frmType == 3 ? 'n' : 'y';

    $FielArr = array(
        'prog_id'             => $dash_cat_id,
        'year_id'     => $year_id,
        'attribute_name'      => htmlspecialchars($prog_name, ENT_QUOTES),
        'attribute_name_hin'  => htmlspecialchars($prog_name_h, ENT_QUOTES),
        'value_type'          => htmlspecialchars($value_type, ENT_QUOTES),
        'value_type_hin'      => htmlspecialchars($value_type_h, ENT_QUOTES),
        'value'               => $value_num,
        'entry_by'            => $_SESSION['userid'],
        'entry_date'          => date('Y-m-d H:i:s'),
    );

    /* -------------------------
       Duplicate Check Section
    --------------------------*/

    if ($frmType == 1) { // Add

        $ChkCat = getNameQry("SELECT prog_data_id FROM web_dash_prog_data WHERE status='Active' AND lower(trim(attribute_name))=lower(trim('$prog_name'))");
        if (!empty($ChkCat)) {
            $result[2] = array(true, 'Requested Name already exist!', 'alert-info');
            var_dump($result);
            exit;
        }

    } elseif ($frmType == 2) { // Update

        if (!isset($_REQUEST['prog_data_id'])) {
            throw new Exception('Program Data ID missing.');
        }

        $prog_data_id = (int)$_REQUEST['prog_data_id'];

        $ChkCat = getNameQry("SELECT prog_data_id FROM web_dash_prog_data WHERE status='Active' AND prog_data_id != $prog_data_id AND lower(trim(attribute_name))=lower(trim('$prog_name'))");

        if (!empty($ChkCat)) {
            $result[2] = array(true, 'Requested Name already exist!', 'alert-info');
            var_dump($result);
            exit;
        }
    }

    /* -------------------------
       Main Operation Section
    --------------------------*/

    switch ($frmType) {

        case 1: // Insert

            $insertRes = insert("web_dash_prog_data", $FielArr, 1);
            $success = ($insertRes !== false);

        break;

        case 2: // Update

            $prog_data_id = (int)$_REQUEST['prog_data_id'];

            $success = update(
                "web_dash_prog_data",
                $FielArr,
                "prog_data_id = $prog_data_id",
                1
            );

        break;

        case 3: // Delete

            if (!isset($_REQUEST['prog_data_id'])) {
                throw new Exception('Program Data ID missing.');
            }

            $prg_did = (int)$_REQUEST['prog_data_id'];

            $success = delete(
                "web_dash_prog_data",
                "prog_data_id = $prg_did",
                1
            );

        break;

        default:
            throw new Exception('Invalid form type.');
    }

    if ($success) {
        $result[0] = true;
    } else {
 
        $result[2] = array(true, 'Operation failed. Please try again.', 'alert-danger');
    }

} catch (Exception $e) {

    $result[2] = array(true, $e->getMessage(), 'alert-danger');
}

/* -------------------------
   Final Response
--------------------------*/

echo frm_response($result);
//var_dump($result);
?>