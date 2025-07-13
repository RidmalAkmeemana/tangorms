<?php
session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include "../commons/fpdf186/fpdf.php";
include_once '../model/report_model.php';

$reportObj = new Report();
$date = date("Y-m-d");

// Get filters from GET
$customer_name = $_GET['customer_name'] ?? 'All';
$from_date     = $_GET['from_date'] ?? '';
$to_date       = $_GET['to_date'] ?? '';

// Convert dates to MySQL format
$from_date = date('Y-m-d', strtotime($from_date));
$to_date   = date('Y-m-d', strtotime($to_date));

// Fetch filtered data
$result = $reportObj->getCustomerOutstandingReport($customer_name, $from_date, $to_date);

// Initialize PDF
$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "CUSTOMER OUTSTANDING REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "As of $date (From $from_date to $to_date)", 0, 1, "L");

// Table headers
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(40, 10, "Receipt No", 1, 0, "C");
$fpdf->Cell(55, 10, "Customer Name", 1, 0, "C");
$fpdf->Cell(35, 10, "Invoice Date", 1, 0, "C");
$fpdf->Cell(30, 10, "Paid", 1, 0, "C");
$fpdf->Cell(30, 10, "Due", 1, 1, "C");

$fpdf->SetFont("Arial", "", 10);

$totalPaid = 0;
$totalDue = 0;

while ($row = $result->fetch_assoc()) {
    $fpdf->Cell(40, 10, $row['receipt_no'], 1, 0, "C");
    $fpdf->Cell(55, 10, $row['customer_name'], 1, 0, "C");
    $fpdf->Cell(35, 10, date('Y-m-d', strtotime($row['invoice_date'])), 1, 0, "C");
    $fpdf->Cell(30, 10, number_format($row['paid_amount'], 2), 1, 0, "R");
    $fpdf->Cell(30, 10, number_format($row['due_amount'], 2), 1, 1, "R");

    $totalPaid += $row['paid_amount'];
    $totalDue  += $row['due_amount'];
}

// Totals
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(130, 10, "Total Amounts", 1, 0, "R");
$fpdf->Cell(30, 10, number_format($totalPaid, 2), 1, 0, "R");
$fpdf->Cell(30, 10, number_format($totalDue, 2), 1, 1, "R");

// Footer
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(190, 10, "This is a computer-generated report. No signature is required.", 1, 1, "C");

$fpdf->Output();
