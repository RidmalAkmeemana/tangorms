<?php
include_once '../commons/session.php';
include_once '../model/module_model.php';
include_once '../model/menu_model.php';
include_once '../commons/helpers/permission_helper.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];

$moduleObj = new Module();
$menuObj = new Menu();

$category_id = base64_decode($_GET["category_id"]);

$result = $menuObj->getCategory($category_id);

// Fetch all rows from the result
$categoryRows = [];
while ($row = $result->fetch_assoc()) {
    $categoryRows[] = $row;
}

// Use first row for category metadata
$firstRow = $categoryRows[0] ?? null;

if (!$firstRow) {
    die("Invalid Category ID or no data found.");
}

$categoryName = $firstRow["category_name"];
$categoryStatus = $firstRow["category_status"];
$categoryStatusClass = $categoryStatus == 1 ? "badge bg-success" : "badge bg-danger";
$categoryStatusText = $categoryStatus == 1 ? "Active" : "Deactive";
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

        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            color: #fff;
            border-radius: 0.375rem;
        }

        .bg-success {
            background-color: #198754;
        }

        .bg-danger {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "CATEGORY DETAILS"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'menu-management-sidebar.php'; ?>

            <div class="col-md-9">
                <?php if (isset($_GET["msg"])): ?>
                    <div class="alert alert-success"><?= base64_decode($_GET["msg"]); ?></div>
                <?php endif; ?>

                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><b>Category Name:</b> <?= htmlspecialchars($categoryName); ?></td>
                            <td><b>Category Status:</b> <span class="<?= $categoryStatusClass ?>"><?= $categoryStatusText ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b>Items in this Category:</b>
                                <ul class="mb-0">
                                    <?php
                                    $hasItems = false;
                                    foreach ($categoryRows as $row):
                                        if (!empty($row['item_name'])):
                                            $hasItems = true;
                                            $itemStatus = $row['item_status'];
                                            $itemStatusClass = $itemStatus == 1 ? "badge bg-success" : "badge bg-danger";
                                            $itemStatusText = $itemStatus == 1 ? "Active" : "Deactive";
                                    ?>
                                            <li>
                                                <b><?= htmlspecialchars($row['item_name']) ?></b> -
                                                <span class="<?= $itemStatusClass ?>"><?= $itemStatusText ?></span>
                                            </li>
                                        <?php
                                        endif;
                                    endforeach;
                                    if (!$hasItems):
                                        ?>
                                        <li><i>No items assigned to this category.</i></li>
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