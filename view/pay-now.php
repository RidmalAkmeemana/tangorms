<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/order_model.php';
include_once '../model/purchasing_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$receipt_no = $_GET["receipt_no"];

// Get user invoice no
$orderObj = new Order();
$orderResult = $orderObj->getOrderByReceiptNo($receipt_no);
$orderItems = $orderObj->getItemsByReceiptNo($receipt_no);

$purchasingObj = new Purchasing();
$orderPayments = $purchasingObj->getPaymentsByReceiptNo($receipt_no);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Summery</title>
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
        <?php $pageName = "PURCHASING MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'purchasing-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/purchasing_controller.php?status=update_order" method="post">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 alert alert-success text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Receipt No and Customer -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Receipt No:</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="receipt_no" value="<?= $orderResult["receipt_no"]; ?>" readonly></div>

                    <div class="col-md-2"><label class="control-label">Customer Name:</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="customer_name" value="<?= $orderResult["customer_name"]; ?>" readonly></div>
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
                                        <th class="text-start">Item Name</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orderItems) && $orderItems->num_rows > 0): ?>
                                        <?php while ($item = $orderItems->fetch_assoc()): ?>
                                            <tr>
                                                <td class="text-start"><?= htmlspecialchars($item["item_code"]); ?></td>
                                                <td class="text-start"><?= htmlspecialchars($item["item_name"]); ?></td>
                                                <td class="text-center"><?= number_format((float)$item["item_price"], 2, '.', ''); ?></td>
                                                <td class="text-center"><?= (int)$item["item_qty"]; ?></td>
                                                <td class="text-center"><?= number_format((float)$item["total_price"], 2, '.', ''); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No items found for this receipt.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Discount and Payment -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Sub Total</label>
                        <input readonly type="number" step="any" name="sub_total_amount" id="sub_total_amount" class="form-control" value="<?= number_format((float)$orderResult["sub_total_amount"], 2, '.', ''); ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Discount (%)</label>
                        <input type="number" name="discount" id="discount" class="form-control" min="0" max="90" value="<?= number_format((float)$orderResult["discount"], 2, '.', ''); ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Grand Total</label>
                        <input readonly type="number" step="any" name="total_amount" id="total_amount" class="form-control" value="<?= number_format((float)$orderResult["total_amount"], 2, '.', ''); ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Payment Method</label>
                        <input readonly type="text" name="payment_method" id="payment_method" class="form-control" value="<?= $orderResult["payment_method"]; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Paid Amount</label>
                        <input type="number" step="any" name="paid_amount" id="paid_amount" class="form-control" value="<?= number_format((float)$orderResult["paid_amount"], 2, '.', ''); ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Due Amount</label>
                        <input readonly type="number" step="any" name="due_amount" id="due_amount" class="form-control" value="<?= number_format((float)$orderResult["due_amount"], 2, '.', ''); ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Balance</label>
                        <input readonly type="number" step="any" name="balance" id="balance" class="form-control" value="<?= number_format((float)$orderResult["balance"], 2, '.', ''); ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Order Type</label>
                        <input readonly type="text" name="order_type" id="order_type" class="form-control" value="<?= $orderResult["order_type"]; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Table Name</label>
                        <input readonly type="text" name="table_id" id="table_id" class="form-control" value="<?= $orderResult["table_name"] ?? "N/A" ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Payment Status</label>
                        <input readonly type="text" name="payment_status" id="payment_status" class="form-control" value="<?= $orderResult["payment_status"]; ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Order Priority</label>
                        <input readonly type="text" name="order_priority" id="order_priority" class="form-control" value="<?= $orderResult["order_priority"]; ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Order Status</label>
                        <input readonly type="text" name="order_status" id="order_status" class="form-control" value="<?= $orderResult["order_status"]; ?>" readonly>
                    </div>

                </div>

                <br>

                <!-- Payment History Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center table-striped" id="cart_table">
                                <thead>
                                    <tr>
                                        <th class="text-start">Payment Receipt</th>
                                        <th class="text-end">Total Price</th>
                                        <th class="text-end">Paid Amount</th>
                                        <th class="text-center">Payment Method</th>
                                        <th class="text-end">Balance</th>
                                        <th class="text-end">Due Amount</th>
                                        <th class="text-start">Payemet Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orderPayments) && $orderPayments->num_rows > 0): ?>
                                        <?php while ($payment = $orderPayments->fetch_assoc()): ?>
                                            <tr>
                                                <td class="text-start"><?= $payment["receipt_no"]."/".$payment["payment_id"]; ?></td>
                                                <td class="text-center"><?= number_format((float)$payment["total_amount"], 2, '.', ''); ?></td>
                                                <td class="text-center"><?= number_format((float)$payment["paid_amount"], 2, '.', ''); ?></td>
                                                <td class="text-start"><?= $payment["payment_method"]; ?></td>
                                                <td class="text-center"><?= number_format((float)$payment["balance"], 2, '.', ''); ?></td>
                                                <td class="text-center"><?= number_format((float)$payment["due_amount"], 2, '.', ''); ?></td>
                                                <td class="text-start"><?= $payment["payment_date"]; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No items found for this receipt.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Amount Pay</label><label class="text-danger">*</label>
                        <input type="number" step="any" name="new_paid_amount" id="new_paid_amount" class="form-control" value="0" required>
                    </div>

                    <div class="col-md-6">
                        <label>Due Amount</label><label class="text-danger">*</label>
                        <input type="number" step="any" name="new_due_amount" id="new_due_amount" class="form-control" value="<?= number_format((float)$orderResult["due_amount"], 2, '.', ''); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Payment Method</label><label class="text-danger">*</label>
                        <select name="new_payment_method" id="new_payment_method" class="form-control" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="row mt-3 text-center">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" value="Pay Now">
                        <input type="reset" class="btn btn-danger" value="Reset">
                    </div>
                </div>
                <br>
            </form>
        </div>

        <script src="../js/jquery-3.7.1.js"></script>
        <script src="../js/uservalidation.js"></script>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const paidInput = document.getElementById('new_paid_amount');
        const dueOutput = document.getElementById('new_due_amount');
        const existingDue = parseFloat(document.getElementById('due_amount').value);
        const paymentMethod = document.getElementById('new_payment_method');
        const form = document.querySelector('form');

        // Update due amount in real-time
        paidInput.addEventListener('input', function () {
            let paidAmount = parseFloat(paidInput.value);

            if (isNaN(paidAmount) || paidAmount < 0) {
                dueOutput.value = existingDue.toFixed(2);
                return;
            }

            let newDue = existingDue - paidAmount;
            if (newDue < 0) newDue = 0;
            dueOutput.value = newDue.toFixed(2);
        });

        // Form validation on submit
        form.addEventListener('submit', function (e) {
            let paidAmount = parseFloat(paidInput.value);

            if (!paymentMethod.value) {
                alert("Please select a payment method.");
                e.preventDefault();
                return;
            }

            if (isNaN(paidAmount) || paidAmount <= 0) {
                alert("Please enter a valid payment amount.");
                e.preventDefault();
                return;
            }

            if (paidAmount > existingDue) {
                alert("Amount Going to Pay is greater than Due Amount.");
                e.preventDefault();
            }
        });
    });
</script>

</body>

</html>