<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/reservation_model.php';
include_once '../model/customer_model.php';
include_once '../model/table_model.php';


checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

$reservation_no = $_GET["reservation_no"];

// Get user reservation no
$reservationObj = new Reservation();
$reservationResult = $reservationObj->getReservationByReservationNo($reservation_no);
$tableResult = $reservationObj->getTables();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation</title>
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
        <?php $pageName = "RESERVATION MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'reservation-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/reservation_controller.php?status=update_reservation" method="post">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 alert alert-success text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reservation No and Customer -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Reservation No:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="reservation_no" value="<?= $reservation_no; ?>" readonly></div>

                    <div class="col-md-2"><label class="control-label">Customer Name:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="customer_name" value="<?= $reservationResult['customer_name']; ?>" readonly></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Table Name:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="table_id" id="table_id" class="form-control" required>
                            <option value="">-- Select Table --</option>
                            <?php while ($tableRow = $tableResult->fetch_assoc()): ?>
                                <option value="<?= $tableRow['table_id']; ?>"
                                    <?= ($reservationResult['table_id'] == $tableRow['table_id']) ? 'selected' : ''; ?>>
                                    <?= $tableRow['table_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-2"><label class="control-label">Reservation Date:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="date" class="form-control" name="reserved_date" value="<?= date('Y-m-d', strtotime($reservationResult['reserved_date'])) ?>" required></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Reservation Status:</label><label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="reservation_status" id="reservation_status" class="form-control" required>
                            <option value="">-- Select Status --</option>
                            <?php
                            $statuses = ["Reserved", "Canceled"];
                            foreach ($statuses as $status):
                            ?>
                                <option value="<?= $status ?>" <?= ($reservationResult["reservation_status"] === $status) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <!-- Submit / Reset Buttons -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <input type="reset" class="btn btn-danger" value="Reset" />
                    </div>
                </div>
                <br>
            </form>
        </div>

        <script src="../js/jquery-3.7.1.js"></script>
        <script src="../js/uservalidation.js"></script>



</body>

</html>