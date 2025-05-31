<?php

include_once '../commons/session.php';
include_once '../model/module_model.php';
include_once '../model/user_model.php';
include_once '../model/table-model.php';

//get user information from session
$userrow=$_SESSION["user"];

$moduleObj = new Module();

$moduleResult = $moduleObj->getAllModules();

$tableObj = new RestaurantTable();

$vacantResult = $tableObj ->getVacantTables();
$vacantRow= $vacantResult->fetch_assoc();

$reservedResult = $tableObj ->getReservedTables();
$reservedRow= $reservedResult->fetch_assoc();

$seatedResult = $tableObj ->getSeatedTables();
$seatedRow= $seatedResult->fetch_assoc();

$dirtyResult = $tableObj ->getDirtyTables();
$dirtyRow= $dirtyResult->fetch_assoc();

$OOSResult = $tableObj ->getOOSTables();
$OOSRow= $OOSResult->fetch_assoc();



?>

<html>
    <head>
         <?php include_once "../includes/bootstrap_css_includes.php"?>
         <script src="../js/plotly-3.0.1.min.js" charset="utf-8"></script>
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

            .panel {
                background-color: #faf7f7;
                border: 1px solid #FF6600;
                color: #333;
                box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
            }

            .panel-info > .panel-heading {
                background-color: #FF6600;
                color: white;
                font-weight: bold;
                text-align: center;
            }

            .panel-body {
                background-color: #faf7f7;
                text-align: center;
            }

            .h1 {
                color: #FF6600;
                font-size: 48px;
            }

            .container {
                padding-top: 30px;
            }


            .col-md-3, .col-md-9 {
                margin-top: 20px;
            }

             Form Controls 
            label.control-label, label.control-lebel {
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

            .btn-primary {
                background-color: #FF6600;
                border-color: #FF6600;
            }

            .btn-primary:hover {
                background-color: #e55d00;
                border-color: #e55d00;
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
</style>
    </head>
    <body>

        <div class="container">
            <?php $pageName = "Table MANAGEMENT" ?>
            <?php include_once "../includes/header_row_includes.php"; ?>


            <div class="col-md-3">
                <ul class="list-group">
                    <a href="add-table.php"class="list-group-item">
                        <span class="glyphicon glyphicon-plus"></span> &nbsp;
                        Add table
                    </a>
                    <a href="view-tables.php"class="list-group-item">
                        <span class="glyphicon glyphicon-search"></span> &nbsp;
                        View tables
                    </a>
                    <a href="addroom.php"class="list-group-item">
                        <span class="glyphicon glyphicon-plus"></span> &nbsp;
                        Add Room
                    </a>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info" style="height:180px">
                            <div class="panel-heading">
                                <p align="center">No of Vacant Tables</p>
                            </div>
                            <div class="panel-body">
                                <h1 class="h1" align="center"><?php echo $vacantRow["vacant_count"]; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info" style="height:180px">
                            <div class="panel-heading">
                                <p align="center">No of Reserved Tables</p>
                            </div>
                            <div class="panel-body">
                                <h1 class="h1" align="center"><?php echo $reservedRow["Reserved_count"]; ?></h1>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info" style="height:180px">
                            <div class="panel-heading">
                                <p align="center">No of Seated Tables</p>
                            </div>
                            <div class="panel-body">
                                <h1 class="h1" align="center"><?php echo $seatedRow["Seated_count"]; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info" style="height:180px">
                            <div class="panel-heading">
                                <p align="center">No of Dirty Tables</p>
                            </div>
                            <div class="panel-body">
                                <h1 class="h1" align="center"><?php echo $dirtyRow["Dirty_count"]; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info" style="height:180px">
                            <div class="panel-heading">
                                <p align="center">No of Out of Service Tables</p>
                            </div>
                            <div class="panel-body">
                                <h1 class="h1" align="center"><?php echo $OOSRow["OOS_count"]; ?></h1>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <div id="tester"></div>
                    </div>
                </div>
            </div>     
        </div>
    </body>
    <div id="messimodal" class="modal fade" role="dialog">
        <div class="modal-dialog">

    
            
           
    </div>
    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
	TESTER = document.getElementById('tester');
	Plotly.newPlot( TESTER, [{
	x: [1, 2, 3, 4, 5],
	y: [1, 2, 4, 8, 16] }], {
	margin: { t: 0 } } );
    </script>
    <script>
                var data = [{
          values: [<?php echo $seatedRow["Seated_count"]; ?>, <?php echo $vacantRow["vacant_count"]; ?>],
          labels: ['Occupied Tables', 'Vacant Tables'],
          type: 'pie'
        }];

        var layout = {
          
          width: 600,
          paper_bgcolor: 'rgba(0,0,0,0)',   // Transparent background for the chart area
          plot_bgcolor: 'rgba(0,0,0,0)'    // Transparent background for the plot area itself
        };

        Plotly.newPlot('tester', data, layout);
     </script>
</html>