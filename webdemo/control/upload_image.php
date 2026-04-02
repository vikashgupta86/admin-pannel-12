<?php
/**
 * Image + PDF Upload for TinyMCE
 * 
 * Allowed:
 * - jpg, jpeg, png (max 500KB)
 * - pdf (max 2MB)
 * 
 * Security:
 * - MIME checking
 * - Image corruption checking (images only)
 */

require_once '../appcode/globals.inc.php';

while (ob_get_level()) {
    ob_end_clean();
}

header('Content-Type: application/json');
header('Content-Encoding: identity');
//header('Cache-Control: no-store, no-cache, must-revalidate');

// AjaxFilePrevent(); 

if (empty($_SESSION['userid'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Session expired or unauthorized.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded.']);
    exit;
}

$file = $_FILES['file'];
$uploadDir = BASE_PATH . "/WriteReadData/RTF1984/";

if (!is_dir($uploadDir)) {
    if (!@mkdir($uploadDir, 0755, true)) {
        echo json_encode(['error' => 'Failed to create upload directory.']);
        exit;
    }
}

if (!is_writable($uploadDir)) {
    echo json_encode(['error' => 'Upload directory not writable.']);
    exit;
}

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Upload failed with error code ' . $file['error']]);
    exit;
}

$fileName = $file['name'];
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

$allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

if (!in_array($fileExt, $allowedExts)) {
    echo json_encode(['error' => 'Extension not allowed. Use JPG, JPEG, PNG or PDF.']);
    exit;
}

$maxSize = ($fileExt === 'pdf') ? 2 * 1024 * 1024 : 500 * 1024;

if ($file['size'] > $maxSize) {
    echo json_encode([
        'error' => ($fileExt === 'pdf') 
            ? 'PDF too large. Max 2MB allowed.' 
            : 'Image too large. Max 500KB allowed.'
    ]);
    exit;
}

$realMime = '';
if (class_exists('finfo')) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $realMime = $finfo->file($file['tmp_name']);
} elseif (function_exists('mime_content_type')) {
    $realMime = mime_content_type($file['tmp_name']);
} else {
    $realMime = $file['type'];
}

$allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];

if (!in_array($realMime, $allowedMimes)) {
    echo json_encode(['error' => 'Invalid file type (MIME mismatch: ' . $realMime . ').']);
    exit;
}

if ($realMime !== 'application/pdf') {

    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        echo json_encode(['error' => 'File is not a valid image.']);
        exit;
    }

    $corrupted = false;

    if ($realMime === 'image/jpeg' && function_exists('imagecreatefromjpeg')) {
        $img = @imagecreatefromjpeg($file['tmp_name']);
        if (!$img) $corrupted = true;
        else imagedestroy($img);
    } elseif ($realMime === 'image/png' && function_exists('imagecreatefrompng')) {
        $img = @imagecreatefrompng($file['tmp_name']);
        if (!$img) $corrupted = true;
        else imagedestroy($img);
    }

    if ($corrupted) {
        echo json_encode(['error' => 'Image appears to be corrupted or invalid.']);
        exit;
    }
}

$prefix = ($fileExt === 'pdf') ? 'RTF-PDF-' : 'RTF-IMG-';
$finalName = $prefix . bin2hex(random_bytes(8)) . '_' . time() . '.' . $fileExt;

$destination = $uploadDir . $finalName;

if (move_uploaded_file($file['tmp_name'], $destination)) {
    $location = "/WriteReadData/RTF1984/" . $finalName;
    echo json_encode(['location' => $location]);
} else {
    echo json_encode(['error' => 'Internal Server Error: Could not save file.']);
}