<?php 
session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include "../commons/fpdf186/fpdf.php";
include_once '../model/report_model.php';

$reportObj = new Report();
$date = date("Y-m-d");

// Get filters
$receipt_no     = $_GET['receipt_no'] ?? 'All';
$payment_status = $_GET['payment_status'] ?? 'All';
$payment_method = $_GET['payment_method'] ?? 'All';
$order_type     = $_GET['order_type'] ?? 'All';
$from_date      = $_GET['from_date'] ?? '';
$to_date        = $_GET['to_date'] ?? '';

// Fetch data
$salesResult = $reportObj->getFilteredSalesReport(
    $receipt_no,
    $payment_status,
    $payment_method,
    $order_type,
    $from_date,
    $to_date
);

$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "SALES REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "Sales records as of $date:", 0, 1, "L");

// Table headers
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(32, 10, "Receipt No", 1, 0, "C");
$fpdf->Cell(28, 10, "Order Type", 1, 0, "C");
$fpdf->Cell(28, 10, "Method", 1, 0, "C");
$fpdf->Cell(28, 10, "Pay Status", 1, 0, "C");
$fpdf->Cell(40, 10, "Invoice Date", 1, 0, "C");
$fpdf->Cell(34, 10, "Total Amount", 1, 1, "C");

$fpdf->SetFont("Arial", "", 10);
$total = 0;
$lineHeight = 5;
$cellHeight = $lineHeight * 2;

while ($row = $salesResult->fetch_assoc()) {
    $invoiceDate = date('Y-m-d', strtotime($row['invoice_date'])) . "\n" . date('H:i:s', strtotime($row['invoice_date']));
    $total += $row['total_amount'];

    $x = $fpdf->GetX();
    $y = $fpdf->GetY();

    // Receipt No
    $fpdf->SetXY($x, $y);
    $fpdf->MultiCell(32, $cellHeight, $row['receipt_no'], 1, 'C');

    // Order Type
    $fpdf->SetXY($x + 32, $y);
    $fpdf->MultiCell(28, $cellHeight, $row['order_type'], 1, 'C');

    // Payment Method
    $fpdf->SetXY($x + 60, $y);
    $fpdf->MultiCell(28, $cellHeight, $row['payment_method'], 1, 'C');

    // Payment Status
    $fpdf->SetXY($x + 88, $y);
    $fpdf->MultiCell(28, $cellHeight, $row['payment_status'], 1, 'C');

    // Invoice Date
    $fpdf->SetXY($x + 116, $y);
    $fpdf->MultiCell(40, $lineHeight, $invoiceDate, 1, 'C');

    // Total Amount
    $fpdf->SetXY($x + 156, $y);
    $fpdf->MultiCell(34, $cellHeight, number_format($row['total_amount'], 2), 1, 'C');

    // Move to next row
    $fpdf->SetY($y + $cellHeight);
}

// Footer - Total
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(156, 10, "Total Sales Amount", 1, 0, "R");
$fpdf->Cell(34, 10, number_format($total, 2), 1, 1, "C");

// Signature note
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(190, 10, "This is a computer-generated document that does not require a signature.", 0, 1, "C");

$fpdf->Output();
