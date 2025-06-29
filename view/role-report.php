<?php 

include "../commons/fpdf186/fpdf.php";
$fpdf = new FPDF("p");

include_once '../model/role_model.php';

$roleObj = new Role();
$roleResult = $roleObj->getAllRoles();

$date = date("Y-m-d");

// Add Page
$fpdf->AddPage("p", "A4");
$fpdf->SetFont("Arial", "", "18");
$fpdf->Image("../images/logo1.png", 10, 20, 20, 20);

// Page Title
$fpdf->Cell(0, 30, "ROLE REPORT", 0, 1, "C");
$fpdf->SetFont("Arial", "", 11);
$fpdf->Cell(0, 10, "The system roles as of $date are listed below:", 0, 1, "L");

// Table Header (Use consistent widths: total = 190)
$fpdf->SetFont("Arial", "B", 11);
$fpdf->Cell(30, 10, "Role ID", 1, 0, "C");
$fpdf->Cell(100, 10, "Role Name", 1, 0, "C");
$fpdf->Cell(60, 10, "Status", 1, 1, "C");

// Table Data
$fpdf->SetFont("Arial", "", 11);

while ($roleRow = $roleResult->fetch_assoc()) {
    $status = ($roleRow["role_status"] == '1') ? "Active" : "Deactive";

    $fpdf->Cell(30, 10, $roleRow['role_id'], 1, 0, "C");
    $fpdf->Cell(100, 10, $roleRow['role_name'], 1, 0, "C");
    $fpdf->Cell(60, 10, $status, 1, 1, "C");
}

// Footer note
$fpdf->SetFont("Arial", "I", 10);
$fpdf->Cell(0, 10, "This is a computer-generated document and does not require a signature.", 1, 1, "C");

$fpdf->Output();
