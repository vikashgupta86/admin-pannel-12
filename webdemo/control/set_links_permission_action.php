<?php
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH . '/control/include/include.inc.php');

    AjaxFilePrevent();
    userAuthenticationPageLevel();

    $result = [0 => false];

    $frmVal = [
        "user_type_id|text|y|1|10|num|Please enter Valid value!"
    ];

    $ValiStr = implode('|$$|', $frmVal);
    $FrmError = $chk->requestcheck($ValiStr, "frmmain", "div", true);

    if ($FrmError) {
        $result[0] = false;
        $result[1] = $FrmError;
        echo frm_response($result);
        exit;
    }

    $user_type_id = isset($_REQUEST['user_type_id']) ? (int)$_REQUEST['user_type_id'] : 0;

    $chk = isset($_REQUEST['chk']) && is_array($_REQUEST['chk']) ? array_map('intval', $_REQUEST['chk']) : [];

    $subQry = "";
    $queries = "";

    if (!empty($chk)) {
        $str = implode(',', $chk);
        $subQry = " AND ls_id NOT IN ($str)";
    }

    $queries .= "UPDATE web_links_permission SET status='Deleted' WHERE status='Active' AND user_id=$user_type_id $subQry|$$|";

    if (!empty($chk)) {
        $sessionUserId = isset($_SESSION['userid']) ? (int)$_SESSION['userid'] : 0;
        $ipAddr = $_SERVER['REMOTE_ADDR'] ?? '';

        foreach ($chk as $val) {
            $queries .= "INSERT INTO web_links_permission (user_id, ls_id, entry_by, entry_date, ip_addr) 
                            SELECT $user_type_id, $val, $sessionUserId, CURRENT_TIMESTAMP, '$ipAddr' FROM web_links_permission 
                                    WHERE status='Active' 
                                        AND user_id=$user_type_id 
                                        AND ls_id=$val 
                                        HAVING COUNT(*)=0|$$|";
        }
    }

    $success = batch_execute($queries);

    if ($success) {
        $result[0] = true;
    }

    echo frm_response($result);