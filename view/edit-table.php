<?php
include '../commons/session.php';
include_once '../model/table_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$tableObj = new Table();
$roomObj = new Table(); // assuming getAllRooms is also in Table class

if (!isset($_GET["table_id"])) {
    die("Invalid request.");
}

$table_id = base64_decode($_GET["table_id"]);
$tableResult = $tableObj->getTable($table_id);
$tableRow = $tableResult->fetch_assoc();
$roomResult  = $roomObj->getAllRooms();
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
    <?php $pageName = "USER MANAGEMENT"; ?>
    <?php include_once "../includes/header_row_includes.php"; ?>
    <?php require 'table-management-sidebar.php'; ?>

    <form action="../controller/table_controller.php?status=update_table" method="post" enctype="multipart/form-data">
        <div class="col-md-9">

            <!-- Message Row -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="row form-section">
                    <div class="col-md-12 alert alert-danger text-center">
                        <?= base64_decode($_GET['msg']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Table Name & Capacity -->
            <div class="row mt-3">
                <input type="hidden" name="table_id" value="<?= $tableRow['table_id']; ?>">
                <div class="col-md-2"><label class="control-label">Table Name</label> <label class="text-danger">*</label></div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="table_name" id="table_name"
                           value="<?= htmlspecialchars($tableRow["table_name"]); ?>" required />
                </div>

                <div class="col-md-2"><label class="control-label">Capacity</label> <label class="text-danger">*</label></div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="seat_count" id="seat_count"
                           value="<?= htmlspecialchars($tableRow["seat_count"]); ?>" required />
                </div>
            </div>

            <!-- Table Status & Room -->
            <div class="row mt-3">
                <div class="col-md-2"><label class="control-label">Table Status</label> <label class="text-danger">*</label></div>
                <div class="col-md-4">
                    <select name="table_status" id="table_status" class="form-control" required>
                        <option value="">---Select Table Status---</option>
                        <?php
                        $statuses = ['Vacant', 'Reserved', 'Seated', 'Dirty', 'Out of Service'];
                        foreach ($statuses as $status) {
                            $selected = ($tableRow["table_status"] == $status) ? "selected" : "";
                            echo "<option value=\"$status\" $selected>$status</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2"><label class="control-label">Room</label> <label class="text-danger">*</label></div>
                <div class="col-md-4">
                    <select name="room_id" id="room_id" class="form-control" required>
                        <option value="">---Select Room---</option>
                        <?php while ($roomRow = $roomResult->fetch_assoc()): ?>
                            <option value="<?= $roomRow["room_id"]; ?>" <?= ($roomRow["room_id"] == $tableRow["room_id"]) ? "selected" : "" ?>>
                                <?= htmlspecialchars($roomRow["room_name"]); ?>
                            </option>
                        <?php endwhile; ?>
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
        </div>
    </form>
</div>

<script src="../js/jquery-3.7.1.js"></script>
<script src="../js/uservalidation.js"></script>
</body>
</html>
