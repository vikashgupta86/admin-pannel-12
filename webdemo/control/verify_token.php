<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once '../appcode/globals.inc.php';
include_once 'include/include.inc.php';
echo "Token for " . session_id() . " at " . 1772021741 . ": \n";
echo csrf_hash(session_id(), 1772021741) . "\n";
?>
