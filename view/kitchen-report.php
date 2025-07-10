<?php 
session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include "../commons/fpdf186/fpdf.php";
include_once '../model/order_model.php';

$orderObj = new Order();
$orderResult = $orderObj->getAllOrders();
$date = date("Y-m-d");

$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "KITCHEN REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system kitchen records as of $date are listed below:", 0, 1, "L");

// Table headers
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(38, 10, "Receipt No", 1, 0, "C");
$fpdf->Cell(58, 10, "Customer Name", 1, 0, "C");
$fpdf->Cell(18, 10, "Status", 1, 0, "C");
$fpdf->Cell(25, 10, "Order Time", 1, 0, "C");
$fpdf->Cell(25, 10, "Last Update", 1, 0, "C");
$fpdf->Cell(25, 10, "Amount", 1, 1, "C");

$fpdf->SetFont("Arial", "", 10);

// Data rows
while ($row = $orderResult->fetch_assoc()) {
    $orderTime = date('Y-m-d', strtotime($row['invoice_date'])) . "\n" . date('H:i:s', strtotime($row['invoice_date']));
    $lastUpdate = date('Y-m-d', strtotime($row['last_update'])) . "\n" . date('H:i:s', strtotime($row['last_update']));

    // Store current X and Y
    $x = $fpdf->GetX();
    $y = $fpdf->GetY();

    // Set height for multiline cells
    $lineHeight = 5;
    $cellHeight = $lineHeight * 2; // Because date/time are two lines

    // Draw each cell manually and manage alignment
    $fpdf->SetXY($x, $y);
    $fpdf->Cell(38, $cellHeight, $row['receipt_no'], 1, 0, "C");

    $fpdf->Cell(58, $cellHeight, $row['customer_name'], 1, 0, "C");
    $fpdf->Cell(18, $cellHeight, $row['order_status'], 1, 0, "C");

    $fpdf->MultiCell(25, $lineHeight, $orderTime, 1, "C");

    // Move to X for Last Update
    $fpdf->SetXY($x + 38 + 58 + 18 + 25, $y);
    $fpdf->MultiCell(25, $lineHeight, $lastUpdate, 1, "C");

    // Move to X for Amount
    $fpdf->SetXY($x + 38 + 58 + 18 + 25 + 25, $y);
    $fpdf->Cell(25, $cellHeight, number_format($row['total_amount'], 2), 1, 1, "C");
}

// Footer
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(189, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

$fpdf->Output();
