<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/report_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$reportObj = new Report();
$customerName = $reportObj->getAllCustomers();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Outstanding Report</title>
    <?php include_once "../includes/bootstrap_css_includes.php"; ?>

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
        <?php $pageName = "CUSTOMER OUTSANDING REPORT"; include_once "../includes/header_row_includes.php"; ?>
        <div class="row">
            <?php include_once 'advanced-report-sidebar.php'; ?>
            <form class="col-md-9" action="view-outstanding-report.php" method="get">
                <div class="row mt-3">
                    <!-- Customer Dropdown -->
                    <div class="col-md-4">
                        <label class="control-label">Customer Name:</label>
                        <select name="customer_name" class="form-control">
                            <option value="All">All</option>
                            <?php while ($row = $customerName -> fetch_assoc()): ?>
                                <option value="<?= $row['customer_name']; ?>"><?= $row['customer_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- From Date -->
                    <div class="col-md-4">
                        <label class="control-label">From Date:</label><label class="text-danger">*</label>
                        <input type="date" name="from_date" class="form-control" required>
                    </div>

                    <!-- To Date -->
                    <div class="col-md-4">
                        <label class="control-label">To Date:</label><label class="text-danger">*</label>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                    
                </div>

                <br>
                <!-- Submit -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="View Report">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
