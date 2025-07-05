<?php

include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/module_model.php';
include_once '../model/room_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];

$moduleObj = new Module();
$roomObj = new Room();

$moduleResult = $moduleObj->getAllModules();
$roomResult = $roomObj->getAllRooms();

?>

<!DOCTYPE html>
<html lang="en">

<head>
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

        .container {
            padding-top: 30px;
        }

        ul.list-group {
            margin-top: 20px;
        }

        .col-md-3,
        .col-md-9 {
            margin-top: 20px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 4px;
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

        .btn {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: black;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }

        .bg-success {
            background-color: #198754;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-primary {
            background-color: #0d6efd;
        }

        .bg-secondary {
            background-color: #6c757d;
        }

        .bg-dark {
            background-color: #343a40;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "TABLE MANAGEMENT"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'table-management-sidebar.php'; ?>

        <div class="col-md-9">
            <?php if (isset($_GET["msg"])): ?>
                <div class="row">
                    <div class="alert alert-success">
                        <?= base64_decode($_GET["msg"]) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center table-striped" id="usertable">
                            <thead>
                                <tr>
                                    <th class="text-start">Room Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" scope="col">Is Enable</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($roomRow = $roomResult->fetch_assoc()): ?>
                                    <?php
                                    $status = $roomRow["room_status"] == 1 ? "Active" : "Deactive";
                                    $status_class = $roomRow["room_status"] == 1 ? "badge bg-success" : "badge bg-danger";
                                    $room_id = base64_encode($roomRow["room_id"]);
                                    ?>
                                    <tr>
                                        <td class="text-start"><?= htmlspecialchars($roomRow["room_name"]) ?></td>
                                        <td>
                                            <span class="<?= $status_class ?> px-3 py-1"><?= $status ?></span>
                                        </td>
                                        <td>
                                            <a href="../controller/room_controller.php?status=<?= $roomRow["room_status"] == 1 ? 'deactivate' : 'activate' ?>&room_id=<?= $room_id ?>"
                                                class="btn btn-sm <?= $roomRow["room_status"] == 1 ? 'btn-danger' : 'btn-success' ?>">
                                                <i class="fa <?= $roomRow["room_status"] == 1 ? 'fa-times' : 'fa-check-circle' ?>"></i>
                                                <?= $roomRow["room_status"] == 1 ? 'Deactivate' : 'Activate' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                <a href="view-room.php?room_id=<?= $room_id ?>" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="edit-room.php?room_id=<?= $room_id ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="../controller/room_controller.php?status=delete&room_id=<?= $room_id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this room?');">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../js/datatable/jquery-3.5.1.js"></script>
<script src="../js/datatable/jquery.dataTables.min.js"></script>
<script src="../js/datatable/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#usertable').DataTable();
    });
</script>

</html>
