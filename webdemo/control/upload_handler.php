<?php
// Set headers for JSON response
header('Content-Type: application/json');

// Configuration: Where to save the files
$upload_dir = "uploads/"; 

// Basic security: Check if directory exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Get the uploaded file
reset($_FILES);
$temp = current($_FILES);

if (is_uploaded_file($temp['tmp_name'])) {
    /* Sanitize filename: 
       Prepend timestamp to prevent overwriting existing files 
    */
    $file_name = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $temp['name']);
    $destination = $upload_dir . $file_name;

    if (move_uploaded_file($temp['tmp_name'], $destination)) {
        // Return success JSON to TinyMCE
        echo json_encode([
            'location' => $destination 
        ]);
    } else {
        header("HTTP/1.1 500 Server Error");
        echo json_encode(['error' => 'Failed to move uploaded file.']);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => 'No file uploaded.']);
}
?>