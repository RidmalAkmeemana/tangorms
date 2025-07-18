<?php 
session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include "../commons/fpdf186/fpdf.php";
include_once '../model/delivery_model.php';

$deliveryObj = new Delivery();
$deliveryResult = $deliveryObj->getAllOrders();
$date = date("Y-m-d");

$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "DELIVERY REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system kitchen records as of $date are listed below:", 0, 1, "L");

// Table Headers
$fpdf->SetFont("Arial", "B", 10);
$fpdf->Cell(33, 10, "Receipt No", 1, 0, "C");
$fpdf->Cell(35, 10, "Customer Name", 1, 0, "C");
$fpdf->Cell(18, 10, "Status", 1, 0, "C");
$fpdf->Cell(24, 10, "Order Time", 1, 0, "C");
$fpdf->Cell(24, 10, "Last Update", 1, 0, "C");
$fpdf->Cell(20, 10, "Amount", 1, 0, "R");
$fpdf->Cell(36, 10, "Reason", 1, 1, "C");

$fpdf->SetFont("Arial", "", 9);
$lineHeight = 5;
$cellHeight = $lineHeight * 2;

while ($row = $deliveryResult->fetch_assoc()) {
    $orderTime = date('Y-m-d', strtotime($row['invoice_date'])) . "\n" . date('H:i:s', strtotime($row['invoice_date']));
    $lastUpdate = date('Y-m-d', strtotime($row['last_update'])) . "\n" . date('H:i:s', strtotime($row['last_update']));
    $reason = empty(trim($row['reason'])) ? 'N/A' : $row['reason'];

    $x = $fpdf->GetX();
    $y = $fpdf->GetY();

    // Receipt No
    $fpdf->SetXY($x, $y);
    $fpdf->Cell(33, $cellHeight, $row['receipt_no'], 1, 0, "C");

    // Customer Name
    $fpdf->SetXY($x + 33, $y);
    $fpdf->Cell(35, $cellHeight, $row['customer_name'], 1, 0, "C");

    // Status
    $fpdf->SetXY($x + 28 + 40, $y);
    $fpdf->Cell(18, $cellHeight, $row['order_status'], 1, 0, "C");

    // Order Time
    $fpdf->SetXY($x + 28 + 40 + 18, $y);
    $fpdf->MultiCell(24, $lineHeight, $orderTime, 1, "C");

    // Last Update
    $fpdf->SetXY($x + 28 + 40 + 18 + 24, $y);
    $fpdf->MultiCell(24, $lineHeight, $lastUpdate, 1, "C");

    // Amount
    $fpdf->SetXY($x + 28 + 40 + 18 + 24 + 24, $y);
    $fpdf->Cell(20, $cellHeight, number_format($row['total_amount'], 2), 1, 0, "R");

    // Reason
    $fpdf->SetXY($x + 28 + 40 + 18 + 24 + 24 + 20, $y);
    $fpdf->Cell(36, $cellHeight, $reason, 1);

    // Move to next row
    $fpdf->SetXY($x, $y + $cellHeight);
}

// Footer
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(190, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

$fpdf->Output();
