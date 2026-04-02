<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once '../appcode/globals.inc.php';
$output = "CSRF Global Secret: " . $GLOBALS['csrf']['secret'] . "\n";
$output .= "csrf_get_secret(): " . csrf_get_secret() . "\n";
$output .= "Session ID: " . session_id() . "\n";
file_put_contents('debug_output.txt', $output);
?>
