<?php
include '../commons/session.php';
include_once '../model/customer_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$customerObj = new Customer();

$customer_id = base64_decode($_GET["customer_id"]);
$customerResult = $customerObj->getCustomer($customer_id);
$customerRow = $customerResult->fetch_assoc();
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
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "POS MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'pos-management-sidebar.php'; ?>

        <form action="../controller/customer_controller.php?status=update_customer" method="post" enctype="multipart/form-data">
            <div class="col-md-9">

                <!-- Message Row -->
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row form-section">
                        <div class="col-md-12 alert alert-danger text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                 <!-- Customer NIC & Name -->
                 <div class="row mt-3">
                    <input type="hidden" name="customer_id" value="<?= $customerRow['customer_id']; ?>">
                    <div class="col-md-2"><label class="control-label">Customer NIC</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input readonly type="text" class="form-control" name="customer_nic" id="customer_nic" value="<?= $customerRow["customer_nic"]; ?>" required /></div>
                    <div class="col-md-2"><label class="control-label">Customer Name</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="customer_name" id="customer_name" value="<?= $customerRow["customer_name"]; ?>" required /></div>
                </div>

                <!-- Mobile & Address -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Customer Mobile</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="number" class="form-control" name="customer_mobile" id="customer_mobile" value="<?= $customerRow["customer_mobile"]; ?>" required /></div>
                    <div class="col-md-2"><label class="control-label">Customer Address</label></div>
                    <div class="col-md-4"><textarea type="text" class="form-control" name="customer_address" id="customer_address"><?= $customerRow["customer_address"]; ?></textarea></div>
                </div>

                <!-- Submit Buttons -->
                <div class="row mt-3 text-center">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-danger" value="Reset">
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../js/uservalidation.js"></script>
    <script>
        function displayImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#img_prev").attr('src', e.target.result).width(80).height(60);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
