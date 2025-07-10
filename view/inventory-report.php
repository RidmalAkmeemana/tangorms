<?php 

session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

// Include the FPDF library
include "../commons/fpdf186/fpdf.php";

// Create FPDF instance
$fpdf = new FPDF("P", "mm", "A4");

// Include inventory model
include_once '../model/inventory_model.php';

$inventoryObj = new Inventory();
$inventoryResult = $inventoryObj->getAllInventories();

$date = date("Y-m-d");

// Add Page
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Page Title
$fpdf->Cell(0, 30, "INVENTORY REPORT", 0, 1, "C");

$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system inventory as of $date is listed below:", 0, 1, "L");

// Set column headers
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(25, 10, "Item Code", 1, 0, "C");
$fpdf->Cell(55, 10, "Item Name", 1, 0, "C");
$fpdf->Cell(25, 10, "Item Price", 1, 0, "C");
$fpdf->Cell(15, 10, "Qty", 1, 0, "C");
$fpdf->Cell(50, 10, "Category Name", 1, 0, "C");
$fpdf->Cell(20, 10, "Status", 1, 1, "C");

// Table Data
$fpdf->SetFont("Arial", "", 11);
$totalInventoryValue = 0;

while ($row = $inventoryResult->fetch_assoc()) {
    $status = $row["item_status"] == 1 ? "Active" : "Inactive";

    $itemTotalValue = $row['item_price'] * $row['item_qty'];
    $totalInventoryValue += $itemTotalValue;

    $fpdf->Cell(25, 10, $row['item_code'], 1, 0, "C");
    $fpdf->Cell(55, 10, $row['item_name'], 1, 0, "C");
    $fpdf->Cell(25, 10, number_format($row['item_price'], 2), 1, 0, "C");
    $fpdf->Cell(15, 10, $row['item_qty'], 1, 0, "C");
    $fpdf->Cell(50, 10, $row['category_name'], 1, 0, "C");
    $fpdf->Cell(20, 10, $status, 1, 1, "C");
}

// Total Inventory Value Row
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(140, 10, "Total Inventory Value (LKR):", 1, 0, "R");  // aligns with previous columns except last 2
$fpdf->Cell(50, 10, number_format($totalInventoryValue, 2), 1, 1, "R"); // value aligns with "Status" column

// Footer Note
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(190, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

// Output PDF
$fpdf->Output();
