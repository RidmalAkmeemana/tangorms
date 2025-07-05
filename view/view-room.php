<?php
include_once '../commons/session.php';
include_once '../model/module_model.php';
include_once '../model/room_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];

$moduleObj = new Module();
$roomObj = new Room();

$room_id = base64_decode($_GET["room_id"]);

$result = $roomObj->getRoom($room_id);
$roomdetailrow = $result->fetch_assoc(); // First row
?>

<html>

<head>
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

        .container {
            padding-top: 30px;
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

        .alert-success {
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        table.table-striped {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .table-striped td {
            padding: 12px;
            vertical-align: middle;
            font-weight: 500;
        }

        .table-striped tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-striped tr:hover {
            background-color: #ffe6cc;
        }

        img {
            border-radius: 6px;
            border: 3px solid #FF6600;
        }

        #display_functions {
            margin-top: 30px;
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
        <?php $pageName = "ROOM DETAILS"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'table-management-sidebar.php'; ?>

            <div class="col-md-9">
                <?php if (isset($_GET["msg"])): ?>
                    <div class="alert alert-success">
                        <?= base64_decode($_GET["msg"]); ?>
                    </div>
                <?php endif; ?>

                <?php
                $status = $roomdetailrow["room_status"] == 1 ? "Active" : "Deactive";
                $status_class = $roomdetailrow["room_status"] == 1 ? "badge bg-success" : "badge bg-danger";
                $img = $roomdetailrow["room_layout"] ?: "user.png";

                // Collect all table rows
                $tables = [];

                if (!empty($roomdetailrow['table_name'])) {
                    $tables[] = $roomdetailrow;
                }

                while ($row = $result->fetch_assoc()) {
                    $tables[] = $row;
                }
                ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <!-- Room Image -->
                            <td rowspan="2" style="width: 220px; text-align: center; vertical-align: middle;">
                                <img src="../images/layouts/<?= htmlspecialchars($img) ?>" width="200px" height="250px" alt="Room Image" />
                            </td>

                            <!-- Room Name -->
                            <td><b>Room Name:</b> <?= htmlspecialchars($roomdetailrow["room_name"]); ?></td>

                            <!-- Room Status -->
                            <td><b>Room Status:</b> <span class="<?= $status_class ?>"><?= $status ?></span></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <b>Tables in this Room:</b>
                                <ul class="mb-0">
                                    <?php if (count($tables) > 0): ?>
                                        <?php foreach ($tables as $table):

                                            $status = $table["table_status"];

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
                                            <li><b><?= htmlspecialchars($table["table_name"]) ?></b> -
                                                <span class="<?= $status_class ?>"><?= htmlspecialchars($table["table_status"]) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><i>No tables assigned to this room.</i></li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
</body>

</html>
