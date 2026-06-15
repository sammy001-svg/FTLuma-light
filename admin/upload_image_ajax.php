<?php
require_once '../functions.php';

if (!is_admin_logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No image provided']);
    exit;
}

$file = $_FILES['image'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    $upload_errors = [
        UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload limit',
        UPLOAD_ERR_FORM_SIZE  => 'File exceeds form size limit',
        UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION  => 'Upload blocked by server extension',
    ];
    echo json_encode(['error' => $upload_errors[$file['error']] ?? 'Upload error ' . $file['error']]);
    exit;
}

// Validate MIME type from file contents, not the extension
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($mime, $allowed)) {
    echo json_encode(['error' => 'Only JPEG, PNG, GIF and WebP images are allowed']);
    exit;
}

if ($file['size'] > 8 * 1024 * 1024) {
    echo json_encode(['error' => 'Image must be under 8 MB']);
    exit;
}

$path = upload_image($file);
if ($path) {
    echo json_encode(['url' => BASE_URL . '/' . $path]);
} else {
    echo json_encode(['error' => 'Failed to save image to disk']);
}
