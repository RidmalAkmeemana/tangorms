<?php 

session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

// Include the FPDF library
include "../commons/fpdf186/fpdf.php";

// Create FPDF instance
$fpdf = new FPDF("P", "mm", "A4");

// Include table model
include_once '../model/table_model.php';

$tableObj = new Table();
$tableResult = $tableObj->getAllTables();

$date = date("Y-m-d");

// Add Page
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Page Title
$fpdf->Cell(0, 30, "TABLE REPORT", 0, 1, "C");

$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The System Users as of $date are listed below:", 0, 1, "L");

// Set column headers (total width = 190 mm)
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(50, 10, "Table Name", 1, 0, "C");
$fpdf->Cell(70, 10, "Room Name", 1, 0, "C");
$fpdf->Cell(40, 10, "Capacity", 1, 0, "C");
$fpdf->Cell(30, 10, "Status", 1, 1, "C");

// Table Data
$fpdf->SetFont("Arial", "", 11);

while ($tableRow = $tableResult->fetch_assoc()) {
    $status = $tableRow["table_status"];
    $tableName = $tableRow['table_name'];

    $fpdf->Cell(50, 10, $tableName, 1, 0, "C");
    $fpdf->Cell(70, 10, $tableRow['room_name'], 1, 0, "C");
    $fpdf->Cell(40, 10, $tableRow['seat_count'], 1, 0, "C");
    $fpdf->Cell(30, 10, $status, 1, 1, "C");
}

// Footer
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(0, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

$fpdf->Output();
