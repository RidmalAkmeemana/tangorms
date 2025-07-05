<?php

include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/module_model.php';
include_once '../model/table_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];

$moduleObj = new Module();
$tableObj = new Table();

$moduleResult = $moduleObj->getAllModules();
$tableResult = $tableObj->getAllTables();

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
                                    <th class="text-start">Table Name</th>
                                    <th class="text-start">Capacity</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Room Name</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($tableRow = $tableResult->fetch_assoc()): ?>
                                    <?php
                                    $status = $tableRow["table_status"];
                                    $table_id = base64_encode($tableRow["table_id"]);

                                    switch ($status) {
                                        case "Vacant":
                                            $status_class = "badge bg-success";
                                            break;
                                        case "Out of Service":
                                            $status_class = "badge bg-secondary";
                                            break;
                                        case "Reserved":
                                            $status_class = "badge bg-warning";
                                            break;
                                        case "Seated":
                                            $status_class = "badge bg-primary";
                                            break;
                                        case "Dirty":
                                            $status_class = "badge bg-danger";
                                            break;
                                        default:
                                            $status_class = "badge bg-dark";
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-start"><?= htmlspecialchars($tableRow["table_name"]) ?></td>
                                        <td class="text-start"><?= htmlspecialchars($tableRow["seat_count"]) ?></td>
                                        <td>
                                            <span class="<?= $status_class ?> px-3 py-1"><?= htmlspecialchars($status) ?></span>
                                        </td>
                                        <td class="text-start"><?= htmlspecialchars($tableRow["room_name"]) ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                <a href="edit-table.php?table_id=<?= $table_id ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pencil"></i>
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
