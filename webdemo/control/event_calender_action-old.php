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

    $event_name     = isset($_REQUEST['event_name']) ? trim($_REQUEST['event_name']) : '';
    $strt_date   = isset($_REQUEST['strt_date']) ? trim($_REQUEST['strt_date']) : '';
    $end_date    = isset($_REQUEST['end_date']) ? trim($_REQUEST['end_date']) : '';
    $evnt_desc     = isset($_REQUEST['evnt_desc']) ? $_REQUEST['evnt_desc'] : '';

    $Fman  = $frmType == 2 ? 'n' : 'y';
    $Fman1 = $frmType == 3 ? 'n' : 'y';

    $FielArr = array(
        'event_name'      => htmlspecialchars($event_name, ENT_QUOTES),
        'event_start_date'  => date('Y-m-d H:i:s', strtotime($strt_date)),
        'event_end_date'          => date('Y-m-d H:i:s', strtotime($end_date)),
        'event_desc'               => htmlspecialchars($evnt_desc, ENT_QUOTES);
        'entry_by'            => $_SESSION['userid'],
        'entry_date'          => date('Y-m-d H:i:s'),
    );

    /* -------------------------
       Duplicate Check Section
    --------------------------*/

    if ($frmType == 1) { // Add

        $ChkCat = getNameQry("SELECT event_id FROM web_events WHERE status='Active' AND lower(trim(event_name))=lower(trim('$event_name'))");
        if (!empty($ChkCat)) {
            $result[2] = array(true, 'Requested Name already exist!', 'alert-info');
            var_dump($result);
            exit;
        }

    } elseif ($frmType == 2) { // Update

        if (!isset($_REQUEST['event_id'])) 
        {
            throw new Exception('Program Data ID missing.');
        }

        $event_id = (int)$_REQUEST['event_id'];

        $ChkCat = getNameQry("SELECT event_id FROM web_events WHERE status='Active' AND event_id != $event_id AND lower(trim(event_name))=lower(trim('$event_name'))");

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

            $insertRes = insert("web_events", $FielArr, 1);
            $success = ($insertRes !== false);

        break;

        case 2: // Update

            $event_id = (int)$_REQUEST['event_id'];

            $success = update(
                "web_events",
                $FielArr,
                "event_id = $event_id",
                1
            );

        break;

        case 3: // Delete

            if (!isset($_REQUEST['event_id'])) {
                throw new Exception('Program Data ID missing.');
            }

            $evnt_id = (int)$_REQUEST['event_id'];

            $success = delete(
                "web_events",
                "evnt_id = $evnt_id",
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