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
    $catName = isset($_REQUEST['c_name']) ? $_REQUEST['c_name'] : '';
    $cat_name_h = isset($_REQUEST['cat_name_h']) ? $_REQUEST['cat_name_h'] : '';

    $Fman  = $frmType == 2 ? 'n' : 'y';
    $Fman1 = $frmType == 3 ? 'n' : 'y';

    $FielArr = array(
        'cat_name'      => htmlspecialchars($catName, ENT_QUOTES),
        'cat_name_h'    => htmlspecialchars($cat_name_h, ENT_QUOTES),
        'creator_id'     => $_SESSION['userid'],
        'entry_by'       => $_SESSION['userid'],
        'creation_date'  => date('Y-m-d H:i:s'),
        'ip_addr'        => $_SERVER['REMOTE_ADDR'],
    );
    
    

 
    if ($frmType == 1) { // Add

        $ChkCat = getNameQry("SELECT t_cat_id FROM web_tender_category WHERE status='Active' AND lower(trim(cat_name))=lower(trim('$catName'))");

        if (!empty($ChkCat)) {
            $result[2] = array(true, 'Requested Category already exist!', 'alert-info');
            // var_dump($result);
            exit;
        }

    } elseif ($frmType == 2) { // Update

        if (!isset($_REQUEST['t_cat_id'])) {
            throw new Exception('Program ID missing.');
        }

        $cat_id = (int)$_REQUEST['t_cat_id'];

        $ChkCat = getNameQry("SELECT t_cat_id FROM web_tender_category WHERE status='Active' AND t_cat_id != $cat_id AND lower(trim(cat_name))=lower(trim('$catName'))");

        if (!empty($ChkCat)) {
            $result[2] = array(true, 'Requested Category already exist!', 'alert-info');
            // var_dump($result);
            exit;
        }
    }

    /* -------------------------
       Main Operation Section
    --------------------------*/

    switch ($frmType) {

        case 1: // Insert

            $success = insert("web_tender_category", $FielArr, 1);
           // $success = ($insertRes !== false);

        break;

        case 2: // Update

            $cat_id = (int)$_REQUEST['t_cat_id'];

            $success = update(
                "web_tender_category",
                $FielArr,
                "t_cat_id = $cat_id",
                1
            );

        break;

        case 3: // Delete

            if (!isset($_REQUEST['t_cat_id'])) {
                throw new Exception('Program ID missing.');
            }

            $cat_id = (int)$_REQUEST['t_cat_id'];

            $success = delete(
                "web_tender_category",
                "t_cat_id = $cat_id",
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


echo frm_response($result);
//var_dump($result);
?>