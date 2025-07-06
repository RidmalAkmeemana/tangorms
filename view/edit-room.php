<?php
include '../commons/session.php';
include_once '../model/room_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$roomObj = new Room();

if (!isset($_GET["room_id"])) {
    die("Invalid request.");
}

$room_id = base64_decode($_GET["room_id"]);
$roomResult = $roomObj->getRoom($room_id);
$roomRow = $roomResult->fetch_assoc();
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
        }

        .list-group-item:hover {
            background-color: #FF6600;
            color: white;
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

        .mt-3 {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
<div class="container">
    <?php $pageName = "TABLE MANAGEMENT"; ?>
    <?php include_once "../includes/header_row_includes.php"; ?>
    <?php require 'table-management-sidebar.php'; ?>

    <form action="../controller/room_controller.php?status=update_room" method="post" enctype="multipart/form-data">
        <div class="col-md-9">

            <!-- Message Row -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="row form-section">
                    <div class="col-md-12 alert alert-danger text-center">
                        <?= base64_decode($_GET['msg']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Room Name & Capacity -->
            <div class="row mt-3">
                <input type="hidden" name="room_id" value="<?= $roomRow['room_id']; ?>">
                <div class="col-md-2"><label class="control-label">Room Name</label> <label class="text-danger">*</label></div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="room_name" id="room_name"
                           value="<?= htmlspecialchars($roomRow["room_name"]); ?>" required />
                </div>

                <div class="col-md-2"><label class="control-label">Room Layout</label></div>
                    <div class="col-md-4">
                        <input type="file" class="form-control" name="room_layout" id="room_layout" required onchange="displayImage(this);" />
                        <?php if (!empty($roomRow["room_layout"])): ?>
                            <img id="img_prev" src="../images/layouts/<?= $roomRow["room_layout"] ?>" width="60" height="60">
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
