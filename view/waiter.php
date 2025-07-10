<?php
include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/module_model.php';
include_once '../model/waiter_model.php';

// Enforce permission check for both module and function
checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$waiterObj = new Waiter();

$orderstatusCounts = $waiterObj->getOrderStatusCounts();
$pendingCount = $orderstatusCounts['pending_count'];
$preparingCount = $orderstatusCounts['preparing_count'];
$readyCount = $orderstatusCounts['ready_count'];
$servedCount = $orderstatusCounts['served_count'];
$completedCount = $orderstatusCounts['completed_count'];
$rejectedCount = $orderstatusCounts['rejected_count'];
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
        <?php $pageName = "WAITER MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'waiter-management-sidebar.php'; ?>

        <div class="col-md-9 row">
            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Pending Orders</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $pendingCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Preparing Orders</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $preparingCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Ready Orders</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $readyCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Served Orders</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $servedCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Out of Completed Orders</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $completedCount; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info" style="height:180px">
                    <div class="panel-heading">No of Out of Rejected Orders</div>
                    <div class="panel-body">
                        <h1 class="h1"><?= $rejectedCount; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
</body>
</html>
