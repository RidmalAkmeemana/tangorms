<?php

include_once '../commons/session.php';
include_once '../model/module_model.php';
include_once '../model/user_model.php';

//get user information from session
$userrow=$_SESSION["user"];

$moduleObj = new Module();

$moduleResult = $moduleObj->getAllModules();



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
            <?php $pageName="Table MANAGEMENT" ?>
            <?php include_once "../includes/header_row_includes.php";?>
            
            
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
                 <div class="col-md-6">
                    <div class="panel panel-info" style="height:180px">
                        <div class="panel-heading">
                            <p align="center">No of Active Tables</p>
                        </div>
                        <div class="panel-body">
                           20
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info" style="height:180px">
                        <div class="panel-heading">
                            <p align="center">No of De-active Tables</p>
                        </div>
                        <div class="panel-body">
                           20
                        </div>
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
</html>