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
    $dash_sb_link_id = isset($_REQUEST['dash_sb_link_id']) ? $_REQUEST['dash_sb_link_id'] : '';
    $progName = isset($_REQUEST['c_name']) ? $_REQUEST['c_name'] : '';
    $progNameHin = isset($_REQUEST['hc_name']) ? $_REQUEST['hc_name'] : '';

    $Fman  = $frmType == 2 ? 'n' : 'y';
    $Fman1 = $frmType == 3 ? 'n' : 'y';


    if(!empty($dash_sb_link_id))
    {
        $FielArr = array(
            'dash_sb_link_id' => $dash_sb_link_id,
            'prog_name'      => htmlspecialchars(trim($progName), ENT_QUOTES),
            'prog_name_hin'  => htmlspecialchars(trim($progNameHin), ENT_QUOTES),
            'entry_by'       => $_SESSION['userid'],
            'entry_date'     => date('Y-m-d H:i:s'),
            'ip_addr'        => $_SERVER['REMOTE_ADDR'],
        );
    }
    else
    {
        $FielArr = array(
            'prog_name'      => htmlspecialchars(trim($progName), ENT_QUOTES),
            'prog_name_hin'  => htmlspecialchars(trim($progNameHin), ENT_QUOTES),
            'entry_by'       => $_SESSION['userid'],
            'entry_date'     => date('Y-m-d H:i:s'),
            'ip_addr'        => $_SERVER['REMOTE_ADDR'],
        );
    }
    

 
    if ($frmType == 1) { // Add

        $ChkCat = getNameQry("SELECT prog_id FROM web_dash_prog WHERE status='Active' AND lower(trim(prog_name))=lower(trim('$progName'))");

        if (!empty($ChkCat)) {
            $result[2] = array(true, 'Requested Category already exist!', 'alert-info');
            // var_dump($result);
            exit;
        }

    } elseif ($frmType == 2) { // Update

        if (!isset($_REQUEST['prog_id'])) {
            throw new Exception('Program ID missing.');
        }

        $prg_id = (int)$_REQUEST['prog_id'];

        $ChkCat = getNameQry("SELECT prog_id FROM web_dash_prog WHERE status='Active' AND prog_id != $prg_id AND lower(trim(prog_name))=lower(trim('$progName'))");

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

            $success = insert("web_dash_prog", $FielArr, 1);
           // $success = ($insertRes !== false);

        break;

        case 2: // Update

            $prg_id = (int)$_REQUEST['prog_id'];

            $success = update(
                "web_dash_prog",
                $FielArr,
                "prog_id = $prg_id",
                1
            );

        break;

        case 3: // Delete

            if (!isset($_REQUEST['prog_id'])) {
                throw new Exception('Program ID missing.');
            }

            $prg_id = (int)$_REQUEST['prog_id'];

            $success = delete(
                "web_dash_prog",
                "prog_id = $prg_id",
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