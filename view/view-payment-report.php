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
$payment_method = $_GET['payment_method'] ?? 'All';
$from_date      = $_GET['from_date'] ?? '';
$to_date        = $_GET['to_date'] ?? '';

// Format dates
$from_date = date('Y-m-d', strtotime($from_date));
$to_date   = date('Y-m-d', strtotime($to_date));

// Fetch filtered payment data
$paymentResult = $reportObj->getFilteredPaymentReport($receipt_no, $payment_method, $from_date, $to_date);

// Create PDF
$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "PAYMENT REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "Payments from $from_date to $to_date", 0, 1, "L");

// Table headers
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(50, 10, "Receipt No / ID", 1, 0, "C");
$fpdf->Cell(40, 10, "Payment Method", 1, 0, "C");
$fpdf->Cell(50, 10, "Payment Date", 1, 0, "C");
$fpdf->Cell(50, 10, "Paid Amount", 1, 1, "C");

$fpdf->SetFont("Arial", "", 10);
$totalPaid = 0;

while ($row = $paymentResult->fetch_assoc()) {
    $fpdf->Cell(50, 10, $row['receipt_no'] . "/" . $row['payment_id'], 1, 0, "C");
    $fpdf->Cell(40, 10, $row['payment_method'], 1, 0, "C");
    $fpdf->Cell(50, 10, date('Y-m-d H:i:s', strtotime($row['payment_date'])), 1, 0, "C");
    $fpdf->Cell(50, 10, number_format($row['paid_amount'], 2), 1, 1, "R");

    $totalPaid += $row['paid_amount'];
}

// Totals
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(140, 10, "Total Paid", 1, 0, "R");
$fpdf->Cell(50, 10, number_format($totalPaid, 2), 1, 1, "R");

// Footer
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(190, 10, "This is a system generated report. No signature required.", 1, 1, "C");

$fpdf->Output();
