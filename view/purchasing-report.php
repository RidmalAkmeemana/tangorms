<?php 
session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include "../commons/fpdf186/fpdf.php";
include_once '../model/purchasing_model.php';

$purchasingObj = new Purchasing();
$paymentResult = $purchasingObj->getAllPayments();
$date = date("Y-m-d");

$fpdf = new FPDF("P", "mm", "A4");
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Title
$fpdf->Cell(0, 30, "PAYMENT REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system payment records as of $date are listed below:", 0, 1, "L");

// Header
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(32, 10, "Receipt No", 1, 0, "C");
$fpdf->Cell(35, 10, "Payment Receipt", 1, 0, "C");
$fpdf->Cell(22, 10, "Total", 1, 0, "C");
$fpdf->Cell(22, 10, "Paid", 1, 0, "C");
$fpdf->Cell(22, 10, "Due", 1, 0, "C");
$fpdf->Cell(25, 10, "Method", 1, 0, "C");
$fpdf->Cell(31, 10, "Payment Date", 1, 1, "C");

$fpdf->SetFont("Arial", "", 10);

// Rows
while ($row = $paymentResult->fetch_assoc()) {
    $paymentDate = date('Y-m-d', strtotime($row['payment_date']));
    $paymentTime = date('H:i:s', strtotime($row['payment_date']));

    $fpdf->Cell(32, 10, $row['receipt_no'], 1, 0, "C");
    $fpdf->Cell(35, 10, $row['receipt_no']."/".$row['payment_id'], 1, 0, "C");
    $fpdf->Cell(22, 10, number_format($row['total_amount'], 2), 1, 0, "R");
    $fpdf->Cell(22, 10, number_format($row['paid_amount'], 2), 1, 0, "R");
    $fpdf->Cell(22, 10, number_format($row['due_amount'], 2), 1, 0, "R");
    $fpdf->Cell(25, 10, $row['payment_method'], 1, 0, "C");
    $fpdf->Cell(31, 5, $paymentDate, "LTR", 2, "C");
    $fpdf->Cell(31, 5, $paymentTime, "LBR", 1, "C");
}

// Footer note
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(189, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

$fpdf->Output();
