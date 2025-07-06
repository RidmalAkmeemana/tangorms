<?php
include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/module_model.php';
include_once '../model/inventory_model.php';

// Enforce permission check for both module and function
checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$inventoryObj = new Inventory();

$activeinventoryCounts = $inventoryObj->getActiveItemCounts();
$activeitemCount = $activeinventoryCounts['active_item_count'];

$inactiveinventoryCounts = $inventoryObj->getInactiveItemCounts();
$inactiveitemCount = $inactiveinventoryCounts['inactive_item_count'];

$zeroactiveinventoryCounts = $inventoryObj->getZeroItemCounts();
$zeroactiveitemCount = $zeroactiveinventoryCounts['zero_item_count'];

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
        <?php $pageName = "INVENTORY & STOCK MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'inventory-management-sidebar.php'; ?>

        <div class="col-md-9 row">
            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Active Items</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $activeitemCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Inactive Items</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $inactiveitemCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Items with 0 Qty</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $zeroactiveitemCount; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
</body>
</html>
