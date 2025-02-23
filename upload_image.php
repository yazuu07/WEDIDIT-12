<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['image']) || empty($data['image']) || !isset($data['location'])) {
    echo json_encode(["success" => false, "error" => "Invalid data provided"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$imageData = $data['image'];
$location = $data['location'];
$note = isset($data['note']) ? $data['note'] : ''; // Check if note is provided

// Decode the base64 image
$imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);
$image = base64_decode($imageData);

if (!$image) {
    echo json_encode(["success" => false, "error" => "Invalid image data"]);
    exit();
}

// Ensure the uploads directory exists
$uploadsDir = 'uploads/';
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

// Generate a unique filename
$filename = uniqid('photo_') . '.jpg';
$filePath = $uploadsDir . $filename;

// Save the image
if (file_put_contents($filePath, $image) === false) {
    echo json_encode(["success" => false, "error" => "Failed to save image"]);
    exit();
}

// Insert the record into the database (note as VARCHAR)
$stmt = $pdo->prepare("INSERT INTO uploads (user_id, image_path, location, note) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$user_id, $filePath, $location, $note])) {
    echo json_encode(["success" => true, "location" => $location, "note" => $note]);
} else {
    echo json_encode(["success" => false, "error" => "Database error"]);
}
?>
