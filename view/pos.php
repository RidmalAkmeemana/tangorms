<?php
include_once '../commons/session.php';
include_once '../model/table-model.php';

$tableObj = new RestaurantTable();
$tableResult = $tableObj->gettables(); // Fetch all tables
?>

<html>
<head>
    <?php include_once "../includes/bootstrap_css_includes.php"?>
    <style>
        /* Add some basic styling for the tables */
        .table-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        .table-item {
            width: 150px;
            height: 100px;
            border: 1px solid #ccc;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .vacant { background-color: lightgreen; }
        .occupied { background-color: yellow; }
        .dirty { background-color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>POS - Select Table</h1>
        <div class="table-container">
            <?php
            while ($table = $tableResult->fetch_assoc()) {
                $statusClass = '';
                if ($table['status_id'] == 1) { // Vacant
                    $statusClass = 'vacant';
                } elseif ($table['status_id'] == 3) { // Occupied
                    $statusClass = 'occupied';
                } elseif ($table['status_id'] == 4) { // Dirty
                    $statusClass = 'dirty';
                }
                echo "<div class='table-item $statusClass' onclick='openBill(" . $table['table_id'] . ")'>" . $table['table_name'] . "</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function openBill(tableId) {
            // Redirect to the open_bill.php page, passing the table ID
            window.location.href = 'open_bill.php?table_id=' + tableId;
        }
    </script>
</body>
</html>