<?php

include_once '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/module_model.php';
include_once '../model/menu_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

//get user information from session
$userrow = $_SESSION["user"];

$moduleObj = new Module();
$menuObj = new Menu();

$moduleResult = $moduleObj->getAllModules();
$menuResult = $menuObj->getAllCategory();


?>

<html>

<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
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

        .success {
            background-color: #d4edda !important;
            color: #155724 !important;
            font-weight: 600;
        }

        .danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            font-weight: 600;
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
            /* Bootstrap success green */
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .user-img {
            border: 2px solid #FF6600;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "MENU MANAGEMENT" ?>
        <?php include_once "../includes/header_row_includes.php"; ?>
        <?php require 'menu-management-sidebar.php'; ?>

        <div class="col-md-9">
            <?php

            if (isset($_GET["msg"])) {

                $msg = base64_decode($_GET["msg"]);

            ?>
                <div class="row">
                    <div class="alert alert-success">
                        <?php echo $msg; ?>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center table-striped" id="usertable">
                            <thead>
                                <tr>
                                    <th class="text-start" scope="col">Category Name</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Is Enable</th>
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($categoryRow = $menuResult->fetch_assoc()): ?>
                                    <?php
                                    $category_id = base64_encode($categoryRow["category_id"]);
                                    $status = $categoryRow["category_status"] == 1 ? "Active" : "Deactive";
                                    $status_class = $categoryRow["category_status"] == 1 ? "badge bg-success" : "badge bg-danger";
                                    ?>
                                    <tr>
                                        <td class="text-start pe-3"><?= htmlspecialchars($categoryRow["category_name"]) ?></td>
                                        <td>
                                            <span class="<?= $status_class ?> px-3 py-1"><?= $status ?></span>
                                        </td>
                                        <td>
                                            <a href="../controller/menu_controller.php?status=<?= $categoryRow["category_status"] == 1 ? 'deactivate' : 'activate' ?>&category_id=<?= $category_id ?>"
                                                class="btn btn-sm <?= $categoryRow["category_status"] == 1 ? 'btn-danger' : 'btn-success' ?>">
                                                <i class="fa <?= $categoryRow["category_status"] == 1 ? 'fa-times' : 'fa-check-circle' ?>"></i>
                                                <?= $categoryRow["category_status"] == 1 ? 'Deactivate' : 'Activate' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                <a href="view-category.php?category_id=<?= $category_id ?>" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="edit-category.php?category_id=<?= $category_id ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="../controller/menu_controller.php?status=delete&category_id=<?= $category_id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this category?');">
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
    $(document).ready(function() {

        $("#usertable").DataTable();
    });
</script>

</html>