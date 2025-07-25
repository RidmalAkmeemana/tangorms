<?php 

session_start();
include_once '../commons/helpers/permission_helper.php';
checkFunctionPermission($_SERVER['PHP_SELF']);

// Include the FPDF library
include "../commons/fpdf186/fpdf.php";

// Create FPDF instance
$fpdf = new FPDF("P", "mm", "A4");

// Include menu model
include_once '../model/menu_model.php';

$menuObj = new Menu();
$categoryResult = $menuObj->getAllCategory();

$date = date("Y-m-d");

// Add Page
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 18);
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Page Title
$fpdf->Cell(0, 30, "CATEGORY REPORT", 0, 1, "C");

$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system category as of $date are listed below:", 0, 1, "L");

// Set column headers (total width = 190 mm)
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(63, 10, "Category ID", 1, 0, "C");
$fpdf->Cell(63, 10, "Category Name", 1, 0, "C");
$fpdf->Cell(63, 10, "Status", 1, 1, "C");

// Table Data
$fpdf->SetFont("Arial", "", 11);

while ($row = $categoryResult->fetch_assoc()) {
    $status = $row["category_status"] == 1 ? "Active" : "Inactive";

    $fpdf->Cell(63, 10, $row['category_id'], 1, 0, "C");
    $fpdf->Cell(63, 10, $row['category_name'], 1, 0, "C");
    $fpdf->Cell(63, 10, $status, 1, 1, "C");
}

// Footer
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(189, 10, "This is a computer-generated document that does not require a signature.", 1, 1, "C");

$fpdf->Output();
