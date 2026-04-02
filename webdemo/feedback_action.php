<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

header('Content-Type: application/json');

$result = [0 => false];

/* -------------------------------------------------
   CSRF Protection (csrf-magic already included)
-------------------------------------------------- */
if (!csrf_check_token()) {
    $result[2] = [true, 'Invalid request token.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

/* -------------------------------------------------
   Strict Input Collection
-------------------------------------------------- */
$frmType = (int) ($_POST['frmType'] ?? 0);
$lid     = (int) ($_POST['lid'] ?? 0);

$f_name  = trim($_POST['f_name'] ?? '');
$address = trim($_POST['address'] ?? '');
$mobile  = trim($_POST['mob'] ?? '');
$email   = trim($_POST['email'] ?? '');
$query   = trim($_POST['query'] ?? '');
$captcha = trim($_POST['captcha'] ?? '');

/* -------------------------------------------------
   CAPTCHA
-------------------------------------------------- */
if ($_ENV['CAPTCHA'] === "true") {

    if (
        empty($_SESSION['captcha_val_cont']) ||
        empty($captcha) ||
        !hash_equals($_SESSION['captcha_val_cont'], $captcha)
    ) {
        $result[2] = [true, 'Incorrect Security Code Entered !', 'alert-danger'];
        echo json_encode($result);
        exit;
    }

    unset($_SESSION['captcha_val_cont']);
}

/* -------------------------------------------------
   Validation
-------------------------------------------------- */

if ($frmType !== 1) {
    $result[2] = [true, 'Invalid form submission.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

if ($lid <= 0) {
    $result[2] = [true, 'Invalid link reference.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

if ($f_name === '' || strlen($f_name) > 100) {
    $result[2] = [true, 'Invalid name.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

if (!preg_match('/^[0-9]{10}$/', $mobile)) {
    $result[2] = [true, 'Invalid mobile number.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result[2] = [true, 'Invalid email address.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

if ($query === '' || strlen($query) > 2000) {
    $result[2] = [true, 'Invalid feedback content.', 'alert-danger'];
    echo json_encode($result);
    exit;
}

/* -------------------------------------------------
   Insert Using Prepared Statement
-------------------------------------------------- */

$sql = "
    INSERT INTO web_feedback
    (feed_type, lid, f_name, addr, email_id, f_details, f_rec_on, mobile)
    VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)
";

$response = db_query(
    $sql,
    "iisssss",
    [
        0,
        $lid,
        $f_name,
        $address,
        $email,
        $query,
        $mobile
    ]
);

if ($response['success']) {
    $result[0] = true;
} else {
    $result[2] = [true, 'Failed to save feedback.', 'alert-danger'];
}

echo json_encode($result);
exit;
