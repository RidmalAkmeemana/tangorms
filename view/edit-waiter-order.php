<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/order_model.php';


checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$receipt_no = $_GET["receipt_no"];

// Get user invoice no
$orderObj = new Order();
$orderResult = $orderObj->getOrderByReceiptNo($receipt_no);
$orderItems = $orderObj->getItemsByReceiptNo($receipt_no);

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
        <?php $pageName = "WAITER MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'waiter-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/waiter_controller.php?status=update_order" method="post">
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
                        <label>Order Status</label><label class="text-danger">*</label>
                        <select name="order_status" id="order_status" class="form-control" required>
                            <option value="">-- Select Order Status --</option>
                            <?php
                            $statuses = ["Ready", "Served", "Completed", "Rejected"];
                            foreach ($statuses as $status):
                            ?>
                                <option value="<?= $status ?>" <?= ($orderResult["order_status"] === $status) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Reason</label><label class="text-danger">*</label>
                        <textarea type="text" class="form-control" name="reason" id="reason" required></textarea>
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

        <script>
            $(document).ready(function() {
                // Initially disable and hide the reason field
                $("#reason").prop("disabled", true).closest('.row').hide();

                $("#order_status").on("change", function() {
                    const selectedStatus = $(this).val();

                    if (selectedStatus === "Rejected" || selectedStatus === "Canceled") {
                        $("#reason").prop("disabled", false).closest('.row').show();
                    } else {
                        $("#reason").prop("disabled", true).val("").closest('.row').hide();
                    }
                });
            });
        </script>
</body>

</html>