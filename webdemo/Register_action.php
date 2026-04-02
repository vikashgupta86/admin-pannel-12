<?php
declare(strict_types=1);

require 'appcode/globals.inc.php';
require_once 'include/website_common.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('Content-Type: application/json');

$response = [
    "success" => false,
    "message" => ""
];

/*
|--------------------------------------------------------------------------
| Only POST allowed
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| CSRF Protection
|--------------------------------------------------------------------------
*/
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    $response['message'] = "Invalid request token.";
    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| CAPTCHA Validation
|--------------------------------------------------------------------------
*/
if (!empty($_ENV['CAPTCHA']) && $_ENV['CAPTCHA'] === "true") {

    $captchaInput = trim($_POST['captcha'] ?? '');

    if (
        empty($_SESSION['captcha_val']) ||
        $captchaInput !== $_SESSION['captcha_val']
    ) {
        $response['message'] = "Incorrect Security Code.";
        echo json_encode($response);
        exit;
    }

    $_SESSION['captcha_val'] = '';
}

/*
|--------------------------------------------------------------------------
| Validate Core Fields
|--------------------------------------------------------------------------
*/
$regtype = filter_input(INPUT_POST, 'regtype', FILTER_VALIDATE_INT);
$email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone   = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
$address = trim($_POST['address'] ?? '');

if (!$regtype || !$email || empty($phone) || empty($address)) {
    $response['message'] = "Required fields missing or invalid.";
    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| Additional Field Validation by Type
|--------------------------------------------------------------------------
*/
$name        = '';
$school      = '';
$department  = '';
$dob         = null;

switch ($regtype) {

    case 1: // School
        $school = trim($_POST['school'] ?? '');
        $name   = trim($_POST['cname'] ?? '');
        if (empty($school) || empty($name)) {
            $response['message'] = "School and Contact Person required.";
            echo json_encode($response);
            exit;
        }
        break;

    case 2: // Student
        $name   = trim($_POST['student'] ?? '');
        $school = trim($_POST['guardian'] ?? '');
        $dob    = $_POST['dob'] ?? null;

        if (empty($name) || empty($school) || empty($dob)) {
            $response['message'] = "Student details incomplete.";
            echo json_encode($response);
            exit;
        }
        break;

    case 3: // Department
        $name       = trim($_POST['dept_name'] ?? '');
        $department = trim($_POST['department'] ?? '');
        if (empty($name) || empty($department)) {
            $response['message'] = "Department details incomplete.";
            echo json_encode($response);
            exit;
        }
        break;

    default:
        $response['message'] = "Invalid registration type.";
        echo json_encode($response);
        exit;
}

/*
|--------------------------------------------------------------------------
| Check Duplicate Email
|--------------------------------------------------------------------------
*/
$stmt = $obj->conn->prepare("SELECT id FROM register WHERE email = ? AND status = 'Active' LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $response['message'] = "Email already exists.";
    echo json_encode($response);
    exit;
}
$stmt->close();

/*
|--------------------------------------------------------------------------
| Generate Secure Password
|--------------------------------------------------------------------------
*/
$plainPassword = bin2hex(random_bytes(4)); // 8 char random
$passwordHash  = password_hash($plainPassword, PASSWORD_BCRYPT);

/*
|--------------------------------------------------------------------------
| Insert Registration
|--------------------------------------------------------------------------
*/
$stmt = $obj->conn->prepare("
    INSERT INTO register 
    (regtype, name, school, department, dob, address, phone, email, password, admin_approved_status, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'approved', NOW())
");

$stmt->bind_param(
    "issssssss",
    $regtype,
    $name,
    $school,
    $department,
    $dob,
    $address,
    $phone,
    $email,
    $passwordHash
);

if ($stmt->execute()) {


    /*
    $subject = "Registration Successful";
    $message = "Your login credentials:\n\nEmail: $email\nPassword: $plainPassword";
    $obj->sendmail($email, $message, $subject);
    */

    $response['success'] = true;
    $response['message'] = "Registration completed successfully.";
} else {
    $response['message'] = "Database error.";
}

$stmt->close();

echo json_encode($response);
exit;
