<?php

include_once '../commons/session.php';
include_once '../model/table-model.php';

//get user information from session
$userrow = $_SESSION["user"];

$tableObj = new RestaurantTable(); // Assuming this class exists

$table_id = $_GET["table_id"];
$tableResult = $tableObj->getTable($table_id);
$tableRow = $tableResult-> fetch_assoc();


$roomResult= $tableObj->getRoom($tableRow['room_id']);
$roomRow = $roomResult->fetch_assoc();


$tableStatus = $tableObj->getTableStatus($tableRow['status_id']);
$statusRow = $tableStatus->fetch_assoc();

?>

<html>

<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="../css/table.css">

</head>

<body>
    <div class="container">
        <?php $pageName = "TABLE DETAILS" ?>
        <?php include_once "../includes/header_row_includes.php"; ?>


        <div class="col-md-2">
            <ul class="list-group">
                <a href="add-table.php"class="list-group-item">
                    <span class="glyphicon glyphicon-plus"></span> &nbsp;
                    Add Table
                </a>
                <a href="edit-table.php"class="list-group-item">
                    <span class="glyphicon glyphicon-plus"></span> &nbsp;
                    Add Room
                </a>
                <a href="editroom.php"class="list-group-item">
                    <span class="glyphicon glyphicon-book"></span> &nbsp;
                    Edit Room
                </a>
            </ul>
        </div>
        <div class="col-md-10">


            <div class="col-md-6">
                <img src="../images/layouts/<?php echo $roomRow['room_layout']; ?>" width="100%" height="auto" />
            </div> 

            <div class="col-md-6">

                
                <table class="table table-bordered table-details">
                    <tr>
                        <th>Table Name</th>
                        <td><?php echo $tableRow['table_name']; ?></td>
                    </tr>
                    <tr>
                        <th>Capacity</th>
                        <td><?php echo $tableRow['capacity']; ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td><?php echo $statusRow['status_name']; ?></td>
                    </tr>
                </table>
            </div>  

        </div>
    </div>

</body>

 <script src="../js/jquery-3.7.1.js"></script>
<script src="../js/datatable/jquery.dataTables.min.js"></script>
    <script src="../js/datatable/dataTables.bootstrap.min.js"></script>
<script src="../js/datatable/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {

        $("#tabletable").DataTable();
    });
</script>

</html>