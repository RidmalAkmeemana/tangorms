<?php

include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/order_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];

$orderObj = new Order();
$orderResult = $orderObj->getAllOrders();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "../includes/bootstrap_css_includes.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #5c5b5b;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #FF6600;
            color: #333;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #FF6600;
            color: white;
        }

        .container {
            padding-top: 30px;
        }

        ul.list-group {
            margin-top: 20px;
        }

        .col-md-3,
        .col-md-9 {
            margin-top: 20px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 4px;
        }

        .table-striped {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .table-striped thead th {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
        }

        .table-striped tbody td {
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-striped tbody tr:hover {
            background-color: #ffe6cc;
        }

        .btn {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: black;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }

        .bg-success {
            background-color: #198754;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-primary {
            background-color: #0d6efd;
        }

        .bg-secondary {
            background-color: #6c757d;
        }

        .bg-dark {
            background-color: #343a40;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "KITCHEN MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'kitchen-management-sidebar.php'; ?>

        <div class="col-md-9">
            <?php if (isset($_GET["msg"])): ?>
                <div class="row">
                    <div class="alert alert-success">
                        <?= base64_decode($_GET["msg"]) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center table-striped" id="usertable">
                            <thead>
                                <tr>
                                    <th class="text-start">Receipt No</th>
                                    <th class="text-start">Customer Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Type</th>
                                    <th class="text-center">Table Name</th>
                                    <th class="text-center">Oder Priority</th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Due Amount</th>
                                    <th class="text-center">Invoice Date</th>
                                    <th class="text-center">Last Payment Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($orderRow = $orderResult->fetch_assoc()): ?>
                                    <?php
                                    $order_status = $orderRow["order_status"];
                                    $receipt_no = $orderRow["receipt_no"];
                                    $payment_status = $orderRow["payment_status"];
                                    $order_priority = $orderRow["order_priority"];

                                    switch (strtolower($order_status)) {
                                        case "pending":
                                            $status_class = "badge bg-warning text-dark"; // yellow
                                            break;
                                        case "preparing":
                                            $status_class = "badge bg-info text-dark"; // light blue
                                            break;
                                        case "served":
                                            $status_class = "badge bg-primary"; // blue
                                            break;
                                        case "delivering":
                                            $status_class = "badge bg-secondary"; // grey
                                            break;
                                        case "completed":
                                            $status_class = "badge bg-success"; // green
                                            break;
                                        case "rejected":
                                            $status_class = "badge bg-danger"; // red
                                            break;
                                        case "canceled":
                                            $status_class = "badge bg-dark"; // black
                                            break;
                                        default:
                                            $status_class = "badge bg-light text-dark"; // fallback
                                            break;
                                    }

                                    switch (strtolower($payment_status)) {
                                        case "fully paid":
                                            $payment_status_class = "badge bg-success";
                                            break;
                                        case "partially paid":
                                            $payment_status_class = "badge bg-warning";
                                            break;
                                        case "unpaid":
                                            $payment_status_class = "badge bg-danger";
                                            break;
                                    }

                                    switch (strtolower($order_priority)) {
                                        case "low":
                                            $priority_status_class = "badge bg-success";
                                            break;
                                        case "moderate":
                                            $priority_status_class = "badge bg-warning";
                                            break;
                                        case "high":
                                            $priority_status_class = "badge bg-danger";
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-start"><?= $orderRow["receipt_no"] ?></td>
                                        <td class="text-start"><?= $orderRow["customer_name"] ?></td>
                                        <td>
                                            <span class="<?= $status_class ?> px-3 py-1"><?= $order_status ?></span>
                                        </td>
                                        <td class="text-start"><?= $orderRow["order_type"] ?></td>
                                        <td class="text-start"><?= !empty($orderRow["table_name"]) ? $orderRow["table_name"] : "N/A" ?></td>
                                        <td>
                                            <span class="<?= $priority_status_class ?> px-3 py-1"><?= $order_priority ?></span>
                                        </td>
                                        <td class="text-start"><?= $orderRow["total_amount"] ?></td>
                                        <td>
                                            <span class="<?= $payment_status_class ?> px-3 py-1"><?= $payment_status ?></span>
                                        </td>
                                        <td class="text-start"><?= $orderRow["due_amount"] ?></td>
                                        <td class="text-start"><?= $orderRow["invoice_date"] ?></td>
                                        <td class="text-start"><?= !empty($orderRow["payment_date"]) ? $orderRow["payment_date"] : "N/A" ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                <a href="edit-kitchen-order.php?receipt_no=<?= $orderRow["receipt_no"] ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../js/datatable/jquery-3.5.1.js"></script>
<script src="../js/datatable/jquery.dataTables.min.js"></script>
<script src="../js/datatable/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usertable').DataTable();
    });
</script>

</html>