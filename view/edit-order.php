<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/pos_model.php';
include_once '../model/customer_model.php';
include_once '../model/menu_model.php';


checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

// Get user invoice no
$posObj = new POS();
$posResult = $posObj->getInvoiceNo();
$tableResult = $posObj->getTables();

// Get user customers for dropdown
$customerObj = new Customer();
$customerResult = $customerObj->getAllCustomers();

$menuObj = new Menu();
$categoryResult = $menuObj->getAllCategory();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>POS Sale</title>
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

        .panel,
        .panel-body {
            background-color: #faf7f7;
            border: 1px solid #FF6600;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
        }

        .panel-info>.panel-heading {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .container {
            padding-top: 30px;
        }

        label.control-label {
            color: white;
            font-weight: 500;
        }

        input.form-control,
        select.form-control {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            color: #333;
        }

        input.form-control:focus,
        select.form-control:focus {
            border-color: #FF6600;
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.6);
        }

        .btn-danger {
            background-color: #aa3333;
            border-color: #aa3333;
        }

        .btn-danger:hover {
            background-color: #992222;
            border-color: #992222;
        }

        #img_prev {
            border: 1px solid #ccc;
            padding: 2px;
            margin-top: 5px;
            border-radius: 4px;
        }

        .mt-3 {
            margin-top: 1rem;
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
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "POS MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'pos-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/pos_controller.php?status=submit_order" method="post">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 alert alert-success text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Receipt No and Customer -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Receipt No:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="receipt_no" value="<?= $posResult; ?>" readonly></div>

                    <div class="col-md-2"><label class="control-label">Customer Name:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="customer_id" id="customer_id" class="form-control" required>
                            <option value="">-- Select Customer --</option>
                            <?php while ($customerRow = $customerResult->fetch_assoc()): ?>
                                <option value="<?= $customerRow['customer_id']; ?>"><?= $customerRow['customer_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <br>

                <!-- Item Cart Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center table-striped" id="cart_table">
                                <thead>
                                    <tr>
                                        <th class="text-start">Item Code</th>
                                        <th class="text-start">Item Image</th>
                                        <th class="text-start">Item Name</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="no-items-row">
                                        <td colspan="7" class="text-center">No items in the cart.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Discount and Payment -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Sub Total</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="sub_total_amount" id="sub_total_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Discount (%)</label><label class="text-danger">*</label>
                        <input type="number" name="discount" id="discount" class="form-control" min="0" max="90" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Grand Total</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="total_amount" id="total_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Payment Method</label><label class="text-danger">*</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Paid Amount</label><label class="text-danger">*</label>
                        <input type="number" step="any" name="paid_amount" id="paid_amount" class="form-control" value="0" required>
                    </div>

                    <div class="col-md-3">
                        <label>Due Amount</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="due_amount" id="due_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Balance</label><label class="text-danger">*</label>
                        <input readonly type="number" step="any" name="balance" id="balance" class="form-control" value="0">
                    </div>

                    <div class="col-md-3">
                        <label>Order Type</label><label class="text-danger">*</label>
                        <select name="order_type" id="order_type" class="form-control" required>
                            <option value="">-- Select Order Type --</option>
                            <option value="Dine-In">Dine-In</option>
                            <option value="Take-Away">Take-Away</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Order Status</label><label class="text-danger">*</label>
                        <select name="order_type" id="order_type" class="form-control" required>
                            <option value="">-- Select Order Type --</option>
                            <option value="Dine-In">Dine-In</option>
                            <option value="Take-Away">Take-Away</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="row mt-3 text-center">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-danger" value="Reset">
                    </div>
                </div>
                <br>
            </form>
        </div>

        <script src="../js/jquery-3.7.1.js"></script>
        <script src="../js/uservalidation.js"></script>
</body>

</html>