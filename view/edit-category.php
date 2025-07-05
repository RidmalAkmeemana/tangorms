<?php
include '../commons/session.php';
include_once '../model/menu_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$menuObj = new Menu();

$categoryResult = $menuObj->getAllCategory();
$category_id = base64_decode($_GET["category_id"]);
$categoryResult = $menuObj->getCategory($category_id);
$categoryRow = $categoryResult->fetch_assoc();
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
        <?php $pageName = "MENU MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'menu-management-sidebar.php'; ?>

        <form action="../controller/menu_controller.php?status=update_category" method="post" enctype="multipart/form-data">
            <div class="col-md-9">

                <!-- Message Row -->
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row form-section">
                        <div class="col-md-12 alert alert-danger text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Category Name -->
                <div class="row mt-3">
                    <input type="hidden" name="category_id" value="<?= $categoryRow['category_id']; ?>">
                    <div class="col-md-12"><label class="control-label">Category Name</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="category_name" id="category_name" value="<?= $categoryRow["category_name"]; ?>" required /></div>
                </div>

                <!-- Submit Buttons -->
                <div class="row mt-3 text-start">
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
</body>

</html>
