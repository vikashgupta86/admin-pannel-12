<?php
require_once '../appcode/globals.inc.php';
include_once 'include/include.inc.php';
header('Content-Type: application/json');
echo json_encode([
    'session_id' => session_id(),
    'csrf_conf' => $GLOBALS['csrf'],
    'csrf_get_secret' => function_exists('csrf_get_secret') ? csrf_get_secret() : 'undefined',
    'test_hash' => function_exists('csrf_hash') ? csrf_hash(session_id(), 1772021741) : 'undefined'
], JSON_PRETTY_PRINT);
