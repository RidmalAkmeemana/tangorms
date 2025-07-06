<?php
include_once '../commons/session.php';
include_once '../model/module_model.php';
include_once '../model/menu_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];

$moduleObj = new Module();
$menuObj = new Menu();

$item_id = base64_decode($_GET["item_id"]);

$itemResult = $menuObj->getItem($item_id);
$itemdetailrow = $itemResult->fetch_assoc();

?>

<html>
<head>
    <?php include_once "../includes/bootstrap_css_includes.php"; ?>
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

        .container {
            padding-top: 30px;
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

        .alert-success {
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        table.table-striped {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .table-striped td {
            padding: 12px;
            vertical-align: middle;
            font-weight: 500;
        }

        .table-striped tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-striped tr:hover {
            background-color: #ffe6cc;
        }

        img {
            border-radius: 6px;
            border: 3px solid #FF6600;
        }

        #display_functions {
            margin-top: 30px;
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
            /* Bootstrap success green */
        }

        .bg-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
    <?php $pageName = "USER PROFILE"; ?>
    <?php include_once "../includes/header_row_includes.php"; ?>

    <div class="row">
        <?php require 'menu-management-sidebar.php'; ?>

        <div class="col-md-9">
            <?php if (isset($_GET["msg"])): ?>
                <div class="alert alert-success">
                    <?= base64_decode($_GET["msg"]); ?>
                </div>
            <?php endif; ?>

            <table class="table table-striped">
                <?php
                    $status = $itemdetailrow["item_status"] == 1 ? "Active" : "Deactive";
                    $status_class = $itemdetailrow["item_status"] == 1 ? "badge bg-success" : "badge bg-danger";
                ?>
                
                <tbody>
                <tr>
                    <td rowspan="4" style="width: 220px;">
                        <?php
                        $img = $itemdetailrow["item_image"] ?: "user.png";
                        ?>
                        <img src="../images/item_images/<?= $img ?>" width="200px" height="250px" alt="User Image"/>
                    </td>
                    <td><b>Item Code:</b> <?= $itemdetailrow["item_code"]; ?></td>
                    <td><b>Item Name:</b> <?= $itemdetailrow["item_name"]; ?></td>
                </tr>
                <tr>
                    <td><b>Item Description:</b> <?= $itemdetailrow["item_description"]; ?></td>
                    <td><b>Item Category:</b> <?= $itemdetailrow["category_name"]; ?></td>
                </tr>
                <tr>
                    <td><b>Item Price</b> <?= $itemdetailrow["item_price"]; ?></td>
                    <td><b>Qty:</b> <?= $itemdetailrow["item_qty"]; ?></td>
                </tr>
                <tr>
                    <td><b>Status:</b> <span class="<?= $status_class ?> px-3 py-1"><?= $status ?></span></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../js/jquery-3.7.1.js"></script>
</body>
</html>
