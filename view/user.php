<?php

include_once '../commons/session.php';
include_once '../model/module_model.php';

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
    background-color: #ffffff; /* FIXED: Removed invalid color '#white' */
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


        </style>
    </head>
    <body>
        <div class="container">
            <?php $pageName="USER MANAGEMENT" ?>
            <?php include_once "../includes/header_row_includes.php";?>
            
            <div class = "col-md-3">
                
                 <ul class="list-group">
                    <a href="add-user.php"class="list-group-item">
                        <span class="glyphicon glyphicon-plus"></span> &nbsp;
                        Add user
                    </a>
                    <a href="view-users.php"class="list-group-item">
                        <span class="glyphicon glyphicon-search"></span> &nbsp;
                        View users
                    </a>
                    <a href="generate-user-reports.php"class="list-group-item">
                        <span class="glyphicon glyphicon-book"></span> &nbsp;
                        Generate user reports
                    </a>
                </ul>
            </div>
                 <div class="col-md-9">
                <div class="col-md-6">
                    <div class="panel panel-info" style="height:180px">
                        <div class="panel-heading">
                            <p align="center">No of Active Users</p>
                        </div>
                        <div class="panel-body">
                            <h1 class="h1" align="center">5</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info" style="height:180px">
                        <div class="panel-heading">
                            <p align="center">No of De-active Users</p>
                        </div>
                        <div class="panel-body">
                            <h1 class="h1" align="center">3</h1>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div>
    </body>
    <script src="../js/jquery-3.7.1.js"></script>
</html><?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

