<?php 

// include the library

include "../commons/fpdf186/fpdf.php";

$fpdf = new FPDF("p");

include_once '../model/user_model.php';
$userObj=new User();
$userResult=$userObj->getAllUsers();




$date=date("Y-m-d");

// Add Page
$fpdf-> AddPage("p", "A4");
$fpdf->SetFont("Arial", "", "18");
$fpdf ->SetFontSize("18");
$fpdf->Image("../images/logo1.png", 10, 20,20,20);

//Page Title
$fpdf->Cell(0, 30,"USER REPORT",0,1,"C");
$fpdf ->SetFontSize("12");
$fpdf->Cell(0, 30,"The System Users as of  $date are as bellow",0,1,"L");

//Header

$fpdf->Cell(60, 10, "Name", 1, 0, "C");
$fpdf->Cell(60, 10, "Email", 1, 0, "C");
$fpdf->Cell(40, 10, "Status", 1, 1, "C");

//data

while($userRow=$userResult->fetch_assoc())
{
$status= ($userRow["user_status"]=='1')?"Active":"Deactive";
$fpdf->Cell(60, 10, $userRow['user_fname']."". $userRow['user_lname'], 1, 0, "C");
$fpdf ->SetFontSize("11");
$fpdf->Cell(60, 10, $userRow['user_email'], 1, 0, "C");
$fpdf ->SetFontSize("12");
$fpdf->Cell(40, 10, "$status", 1, 1, "C");

}


$fpdf ->SetFontSize("10");
$fpdf->Cell(0, 10, "This is a computer generated document that does not require a signature", 1, 1, "C");





$fpdf->Output();