<?php

include 'appcode/globals.inc.php';
include_once 'include/website_common.inc.php';

session_start();

$timeStamp = date('Y-m-d H:i:s');
$userId = isset($_SESSION['userid']) ? (int)$_SESSION['userid'] : 0;
$lang   = isset($_SESSION['lang']) ? $_SESSION['lang'] : 1;

if ($userId > 0) {

    $rs = $obj->simplefetch(
        "SELECT id 
         FROM web_loginoroffusertrail 
         WHERE userid = $userId 
         ORDER BY id DESC 
         LIMIT 1",
        1
    );

    if ($rs[0] > 0) {
        $row = $rs[1][0];
        $trailId = (int)$row['id'];

        $obj->simplefetch(
            "UPDATE web_loginoroffusertrail 
             SET dateoflogoff = '$timeStamp' 
             WHERE id = $trailId"
        );
    }
}

/* Proper logout sequence */
$_SESSION = [];
session_unset();
session_destroy();

header("Location: /");
//header("Location: " . $obj->BaseUrl() . "/index.php?lang=" . $lang);
exit;
