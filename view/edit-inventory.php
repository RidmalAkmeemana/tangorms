<?php
include '../commons/session.php';
include_once '../model/inventory_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$inventoryObj = new Inventory();

$categoryResult = $inventoryObj->getAllCategory();
$item_id = base64_decode($_GET["item_id"]);
$inventoryResult = $inventoryObj->getInventory($item_id);
$inventoryRow = $inventoryResult->fetch_assoc();
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
        <?php $pageName = "INVENTORY MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'inventory-management-sidebar.php'; ?>

        <form action="../controller/inventory_controller.php?status=update_inventory" method="post" enctype="multipart/form-data">
            <div class="col-md-9">

                <!-- Message Row -->
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row form-section">
                        <div class="col-md-12 alert alert-danger text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Item Code -->
                <div class="row mt-3">
                    <input type="hidden" name="item_id" value="<?= $inventoryRow['item_id']; ?>">
                    <div class="col-md-2"><label class="control-label">Item Code</label><label class="text-danger">*</label></div>
                    <div class="col-md-10"><input disabled type="text" class="form-control" name="item_code" id="item_code" value="<?= $inventoryRow["item_code"]; ?>" required /></div>
                </div>

                <!-- Item Image & Name -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Item Name</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input disabled type="text" class="form-control" name="item_name" id="item_name" value="<?= $inventoryRow["item_name"]; ?>" required /></div>
                    <div class="col-md-2"><label class="control-label">Item Description</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><textarea disabled type="text" class="form-control" name="item_description" id="item_description" required><?= $inventoryRow["item_description"]; ?></textarea></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Unit Price</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="number" step="any" class="form-control" name="item_price" id="item_price" value="<?= $inventoryRow["item_price"]; ?>" required /></div>
                    <div class="col-md-2"><label class="control-label">Item Category</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><select disabled name="item_category" id="item_category" class="form-control" required>
                            <option value="">---Select Category---</option>
                            <?php while ($categoryRow = $categoryResult->fetch_assoc()): ?>
                            <option value="<?= $categoryRow["category_id"]; ?>" <?= ($categoryRow["category_id"] == $inventoryRow["item_category"]) ? "selected" : "" ?>>
                                <?= htmlspecialchars($categoryRow["category_name"]); ?>
                            </option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Qty</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="number" class="form-control" name="item_qty" id="item_qty" value="<?= $inventoryRow["item_qty"]; ?>" required /></div>
                    <div class="col-md-2"><label class="control-label">Item Image</label><label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <?php if (!empty($inventoryRow["item_image"])): ?>
                            <!-- Show disabled input with current file name -->
                            <input type="text" class="form-control" value="<?= htmlspecialchars($inventoryRow["item_image"]) ?>" disabled />

                            <!-- Hidden actual file input for image update if needed -->
                            <input type="file" class="form-control mt-2" name="item_image" id="item_image" onchange="displayImage(this);" style="display: none;" />

                            <!-- Preview Image -->
                            <img id="img_prev" src="../images/item_images/<?= htmlspecialchars($inventoryRow["item_image"]) ?>" width="60" height="60" style="margin-top: 10px; display:block;">
                        <?php else: ?>
                            <!-- No existing image: normal file input -->
                            <input type="file" class="form-control" name="item_image" id="item_image" required onchange="displayImage(this);" />
                        <?php endif; ?>
                    </div>
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
