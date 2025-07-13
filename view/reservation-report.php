<?php 
session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include "../commons/fpdf186/fpdf.php";
include_once '../model/reservation_model.php';

$reservationObj = new Reservation();
$reservationResult = $reservationObj->getAllReservations();
$date = date("Y-m-d");

$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "RESERVATION REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system kitchen records as of $date are listed below:", 0, 1, "L");

// Table headers
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(38, 10, "Reservation No", 1, 0, "C");
$fpdf->Cell(58, 10, "Customer Name", 1, 0, "C");
$fpdf->Cell(25, 10, "Status", 1, 0, "C");
$fpdf->Cell(30, 10, "Table Name", 1, 0, "C");
$fpdf->Cell(39, 10, "Reserved Date", 1, 1, "C");

$fpdf->SetFont("Arial", "", 10);
$lineHeight = 5;
$rowHeight = $lineHeight * 2;

// Data rows
while ($row = $reservationResult->fetch_assoc()) {
    $reservedDate = date('Y-m-d', strtotime($row['reserved_date'])) . "\n" . date('H:i:s', strtotime($row['reserved_date']));

    $x = $fpdf->GetX();
    $y = $fpdf->GetY();

    // Column 1: Reservation No
    $fpdf->SetXY($x, $y);
    $fpdf->Cell(38, $rowHeight, $row['reservation_no'], 1, 0, 'C');

    // Column 2: Customer Name
    $fpdf->Cell(58, $rowHeight, $row['customer_name'], 1, 0, 'C');

    // Column 3: Status
    $fpdf->Cell(25, $rowHeight, $row['reservation_status'], 1, 0, 'C');

    // Column 4: Table Name
    $fpdf->Cell(30, $rowHeight, $row['table_name'], 1, 0, 'C');

    // Column 5: Reserved Date (Multiline)
    $fpdf->MultiCell(39, $lineHeight, $reservedDate, 1, 'C');

    // Set cursor to correct start of next row (after MultiCell)
    $fpdf->SetX($x);
    $fpdf->SetY($y + $rowHeight);
}

$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(190, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

$fpdf->Output();
