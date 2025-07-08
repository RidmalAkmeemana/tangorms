<?php
session_start();

include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

include_once '../commons/db_connection.php';
include '../commons/fpdf186/fpdf.php';
include_once '../model/pos_model.php';

if (!isset($_GET['receipt_no']) || empty($_GET['receipt_no'])) {
    die("Receipt No is missing.");
}

$receipt_no = $_GET['receipt_no'];
$posObj = new POS();

// Fetch order
$order = $posObj->getOrderByReceiptNo($receipt_no);
if (!$order) {
    die("Order not found.");
}

// Fetch order items
$items_result = $posObj->getOrderItemsByReceiptNo($receipt_no);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Logo & Title
$pdf->Image('../images/logo1.png', 10, 10, 20, 20);
$pdf->Cell(0, 10, 'TANGO RMS - Receipt', 0, 1, 'C');
$pdf->Cell(0, 10, 'Reprint', 0, 1, 'C');
$pdf->Ln(15);

// Order Info
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 6, 'Receipt No:', 0, 0);
$pdf->Cell(80, 6, $receipt_no, 0, 1);
$pdf->Cell(40, 6, 'Date:', 0, 0);
$pdf->Cell(80, 6, date('Y-m-d H:i:s', strtotime($order['payment_date'] ?? $order['order_date'] ?? date('Y-m-d H:i:s'))), 0, 1);
$pdf->Cell(40, 6, 'Customer Name:', 0, 0);
$pdf->Cell(80, 6, $order['customer_name'], 0, 1);
$pdf->Cell(40, 6, 'Order Type:', 0, 0);
$pdf->Cell(80, 6, $order['order_type'], 0, 1);
$pdf->Cell(40, 6, 'Table:', 0, 0);
$pdf->Cell(80, 6, $order['table_name'] ?? '-', 0, 1);
$pdf->Ln(5);

// Table Headers with borders
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(48, 8, 'Item Code', 1, 0, 'C');
$pdf->Cell(60, 8, 'Item Name', 1, 0, 'C');
$pdf->Cell(20, 8, 'Qty', 1, 0, 'C');
$pdf->Cell(30, 8, 'Price', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 1, 'C');

// Table Data with borders
$pdf->SetFont('Arial', '', 11);
while ($item = $items_result->fetch_assoc()) {
    $pdf->Cell(48, 8, $item['item_code'], 1);
    $pdf->Cell(60, 8, substr($item['item_name'], 0, 28), 1); // limit name to fit
    $pdf->Cell(20, 8, $item['item_qty'], 1, 0, 'C');
    $pdf->Cell(30, 8, number_format($item['item_price'], 2), 1, 0, 'R');
    $pdf->Cell(30, 8, number_format($item['total_price'], 2), 1, 1, 'R');
}

// Totals
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(158, 8, 'Subtotal:', 0, 0, 'R');
$pdf->Cell(30, 8, number_format($order['sub_total_amount'], 2), 0, 1, 'R');

$pdf->Cell(158, 8, 'Discount:', 0, 0, 'R');
$pdf->Cell(30, 8, number_format($order['discount'], 2), 0, 1, 'R');

$pdf->Cell(158, 8, 'Total:', 0, 0, 'R');
$pdf->Cell(30, 8, number_format($order['total_amount'], 2), 0, 1, 'R');

$pdf->Cell(158, 8, 'Paid:', 0, 0, 'R');
$pdf->Cell(30, 8, number_format($order['paid_amount'], 2), 0, 1, 'R');

$pdf->Cell(158, 8, 'Balance:', 0, 0, 'R');
$pdf->Cell(30, 8, number_format($order['balance'], 2), 0, 1, 'R');

$pdf->Cell(158, 8, 'Due Amount:', 0, 0, 'R');
$pdf->Cell(30, 8, number_format($order['due_amount'], 2), 0, 1, 'R');

// Footer
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'This is a computer-generated receipt.', 0, 1, 'C');

// Output PDF
$pdf->Output("I", "Receipt_$receipt_no.pdf"); // I = inline in browser
exit;
