<?php

include_once '../commons/session.php';
include_once '../model/table-model.php';

//getting user information from session
$userrow = $_SESSION["user"];

$tableObj = new RestaurantTable(); 

$tableResult = $tableObj->gettables();


?>

<html>

<head>
    <?php include_once "../includes/bootstrap_css_includes.php"?>
        <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css"/>
    
    <link rel="stylesheet" type="text/css" href="../css/table.css"/>

</head>

<body>
    <div class="container">
        <?php $pageName = "TABLE MANAGEMENT" ?>
        <?php include_once "../includes/header_row_includes.php"; ?>


        <div class="col-md-3">
            <ul class="list-group">
                <a href="add-table.php"class="list-group-item">
                    <span class="glyphicon glyphicon-plus"></span> &nbsp;
                    Add Table
                </a>
                <a href="addroom.php"class="list-group-item">
                    <span class="glyphicon glyphicon-plus"></span> &nbsp;
                    Add Room
                </a>
                <a href="editroom.php"class="list-group-item">
                    <span class="glyphicon glyphicon-book"></span> &nbsp;
                    Edit Room
                </a>
            </ul>
        </div>
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
                <div class="col-md-12">
                    <table class="table table-striped" id="ttable">
                        <thead>
                            <tr>
                                <th>Table Name</th>
                                <th>Capacity</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
while ($tableRow = $tableResult->fetch_assoc()) {
    ?>

                                <tr>
                                    <td>
    <?php echo $tableRow["table_name"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $tableRow["capacity"]; ?>
                                    </td>

                                    <td>
    <?php echo $tableRow["room_name"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $tableRow["status_name"]; ?>
                                    </td>

                                    <td>
                                        <a href="view-table.php?table_id=<?php echo $tableRow["table_id"]; ?>" class="btn btn-info">
                                            <span class="glyphicon glyphicon-search"></span>
                                            &nbsp;
                                            View
                                        </a>
                                        &nbsp;
                                        <a href="edit-table.php?table_id=<?php echo $tableRow["table_id"] ?>" class="btn btn-warning">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                            &nbsp;
                                            Edit
                                        </a>

                                        &nbsp;


                                        <a href="../controller/table_controller.php?status=delete&table_id=<?php echo $tableRow["table_id"] ?>" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            &nbsp;
                                            Delete
                                        </a>
                                    </td>
                                </tr>
    <?php
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../js/datatable/jquery-3.5.1.js"></script>
    <script src="../js/datatable/jquery.dataTables.min.js"></script>
    <script src="../js/datatable/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            
            $("#ttable").DataTable();
        });
    </script>

</html>