<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/table_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

// Get user roles for dropdown
$roomObj     = new Table();
$roomResult  = $roomObj->getAllRooms();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Table</title>
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
        <?php $pageName = "TABLE MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'table-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/table_controller.php?status=add_table" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 alert alert-danger text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Table Name & Capacity -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Table Name</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="table_name" id="table_name" required /></div>
                    <div class="col-md-2"><label class="control-label">Seat Count</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="number" class="form-control" name="seat_count" id="seat_count" required /></div>
                </div>

                <!-- Table Status -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Table Status</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="table_status" id="table_status" class="form-control" required>
                            <option value="">---Select Table Status---</option>
                            <option value="Vacant">Vacant</option>
                            <option value="Out of Service">Out of Service</option>
                            <option value="Reserved">Reserved</option>
                            <option value="Seated">Seated</option>
                            <option value="Dirty">Dirty</option>
                        </select>
                    </div>

                    <div class="col-md-2"><label class="control-label">Room</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="room_id" id="room_id" class="form-control" required>
                            <option value="">---Select Room---</option>
                            <?php while ($roomRow = $roomResult->fetch_assoc()): ?>
                                <option value="<?= $roomRow['room_id']; ?>"><?= $roomRow['room_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
        <!-- Dynamic Functions Placeholder -->
        <div class="row mt-3">
            <div id="display_functions" class="col-md-12"></div>
        </div>

        <!-- Submit / Reset Buttons -->
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <input type="submit" class="btn btn-primary" value="Submit" />
                <input type="reset" class="btn btn-danger" value="Reset" />
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
                const reader = new FileReader();
                reader.onload = e => {
                    if (!document.getElementById('img_prev')) {
                        const img = document.createElement('img');
                        img.id = 'img_prev';
                        input.parentNode.appendChild(img);
                    }
                    document.getElementById('img_prev').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>