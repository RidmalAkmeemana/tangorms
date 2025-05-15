<?php

include '../commons/session.php';
include_once '../model/table-model.php';

//get user information from session
$userrow=$_SESSION["user"];

$tableObj = new RestaurantTable();

$roomResult = $tableObj->getAllRooms();
$roomStatus = $tableObj->getAllStatus();
?>

<html>
    <head>
        <?php include_once "../includes/bootstrap_css_includes.php"?>
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

    ul.list-group {
        margin-top: 20px;
    }

    .col-md-3, .col-md-9 {
        margin-top: 20px;
    }

    /* Form Controls */
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
            <?php $pageName = "Add Table" ?>
            <?php include_once "../includes/header_row_includes.php"; ?>

            <div class="col-md-3">
                <ul class="list-group">
                    <a href="addroom.php"class="list-group-item">
                        <span class="glyphicon glyphicon-plus"></span> &nbsp;
                        Add Room
                    </a>
                    <a href="edittable.php"class="list-group-item">
                        <span class="glyphicon glyphicon-book"></span> &nbsp;
                        Edit Table
                    </a>
                    <a href="editroom.php"class="list-group-item">
                        <span class="glyphicon glyphicon-book"></span> &nbsp;
                        Edit Room
                    </a>
                </ul>
            </div>
            <form action="../controller/table_controller.php?status=store" method="post" enctype="multipart/form-data">
                <div class = "col-md-9">
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Table Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="table_name" id="table_name" required="required"/>
                    </div>
                </div>


                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Capacity</label>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control" name="capacity" id="capacity" min="1" required="required" />
                        </div>
                    </div>
                    
                   <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Room</label>
                    </div>
                    <div class="col-md-3">
                        <select name="room" id="room" class="form-control" required="required">
                            <option>----------------</option>
                            <?php 
                                    while($roomRow=$roomResult->fetch_assoc())
                                    {
                                ?>
                                <option value="<?php echo $roomRow["room_id"]; ?>">
                                    <?php echo $roomRow["room_name"];?>
                                </option>
                                <?php
                                    }
                                ?>
                        </select>
                    </div>
                     </div>

                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Status</label>
                    </div>
                    <div class="col-md-3">
                        <select name="status" id="status" class="form-control" required="required">
                            
                            <?php 
                                    while($statusRow=$roomStatus->fetch_assoc())
                                    {
                                ?>
                                <option value="<?php echo $statusRow["status_id"]; ?>">
                                    <?php echo $statusRow["status_name"];?>
                                </option>
                                <?php
                                    }
                                ?>
                        </select>
                    </div>
                </div>
    
                <div class="row">
                   &nbsp;
                </div>
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <input type="submit" class="btn btn-primary" value="Submit"/>
                        <input type="reset" class="btn btn-danger" value="Reset"/>
                    </div>
                </div>   
            </div>
        </form>
        
    </div>


</body>
<script src="../js/jquery-3.7.1.js"></script>
<script src="../js/uservalidation.js"></script>
<script>
    function displayImage(input){
        if(input.files && input.files[0])
        {
           var reader = new FileReader();
           reader.onload = function (e){
           $("#img_prev").attr('src',e.target.result).width(80).height(60);
               
           };
           reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</html>


