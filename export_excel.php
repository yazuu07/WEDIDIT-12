<?php
session_start();
require 'db.php';

// Include PhpSpreadsheet library
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Redirect if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user, start date, and end date parameters
if (!isset($_GET['user']) || !isset($_GET['start_date']) || !isset($_GET['end_date'])) {
    echo "User or date range not specified.";
    exit();
}

$username = $_GET['user'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date']; 

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM admin1 WHERE user = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

$user_id = $user['id'];

// Prepare the query to fetch images and notes for the selected date range
$query = "SELECT image_path, location, uploaded_at, note FROM uploads WHERE user_id = ? AND DATE(uploaded_at) BETWEEN ? AND ? ORDER BY uploaded_at ASC";
$params = [$user_id, $start_date, $end_date];

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any images for the selected date range
if (empty($images)) {
    echo "No images found for the selected date range. Export canceled.";
    exit();
}

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row
$headers = ['Name', 'Upload_at', 'Time In', 'Time Out', 'Remark 1', 'Location', 'Note'];
$sheet->fromArray($headers, NULL, 'A1');

// Prepare data rows
$row = 2;
$lastTimeIn = null;

foreach ($images as $image) {
    $name = $username;
    $location = $image['location'];
    $uploadedAt = $image['uploaded_at'];
    $note = $image['note'];  // Fetch the note

    // Determine Time In, Time Out, and calculate remarks
    if ($location === 'In') {
        $timeIn = $uploadedAt;
        $timeOut = '';
        $lastTimeIn = $timeIn; // Save the last "In" time
        $remark1 = '';
    } elseif ($location === 'Out' && $lastTimeIn) {
        $timeIn = $lastTimeIn;
        $timeOut = $uploadedAt;
        $lastTimeIn = null; // Reset after pairing with "Out"

        // Calculate hours worked
        $hoursWorked = (strtotime($timeOut) - strtotime($timeIn)) / 3600;

        // Assign Remark 1 based on hours worked
        if ($hoursWorked < 9) {
            $remark1 = 'Undertime';
        } elseif ($hoursWorked >= 9 && $hoursWorked <= 10) {
            $remark1 = 'On Time';
        } else {
            $remark1 = 'Overtime';
        }
    } else {
        $timeIn = '';
        $timeOut = '';
        $remark1 = '';
    }

    // Write data to the spreadsheet
    $sheet->setCellValue("A$row", $name);
    $sheet->setCellValue("B$row", $uploadedAt);
    $sheet->setCellValue("C$row", $timeIn);
    $sheet->setCellValue("D$row", $timeOut);
    $sheet->setCellValue("E$row", $remark1);
    $sheet->setCellValue("F$row", $location);
    $sheet->setCellValue("G$row", $note);  // Write the note to the "Note" column

    $row++;
}

// Set column widths for better visibility
foreach (range('A', 'G') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Set the filename (include the date range in the filename)
$filename = "Export_" . $username . "_" . $start_date . "_to_" . $end_date . ".xlsx";

// Send the file as a download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
