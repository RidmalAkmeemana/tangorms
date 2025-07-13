<?php
include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/module_model.php';
include_once '../model/report_model.php';

// Enforce permission check for both module and function
checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$reportObj = new Report();

$totalSalesCounts = $reportObj->getTotalSalesAmount();
$totalSales = number_format($totalSalesCounts['total_sales'], 2);
$totalRecived = number_format($totalSalesCounts['total_received'], 2);
$totalOutstanding = number_format($totalSalesCounts['total_outstanding'], 2);
?>

<html>
<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
    <style>
        body {
            background-color: #5c5b5b;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .panel {
            background-color: #faf7f7;
            border: 1px solid #FF6600;
            color: #333;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
        }
        .panel-info > .panel-heading {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .panel-body {
            background-color: #faf7f7;
            text-align: center;
        }
        .h1 {
            color: #FF6600;
            font-size: 48px;
        }
        .container {
            padding-top: 30px;
        }
        .col-md-6 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "ADVANCED REPORTS"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'advanced-report-sidebar.php'; ?>

        <div class="col-md-9 row">
            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">Total Sales Amount</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $totalSales; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">Total Recived Amount</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $totalRecived; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">Total Oystanding Amount</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $totalOutstanding; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
</body>
</html>
