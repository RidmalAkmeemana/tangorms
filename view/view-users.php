<?php

include_once '../commons/session.php';
include_once '../model/module_model.php';
include_once '../model/user_model.php';

//get user information from session
$userrow=$_SESSION["user"];
 
$moduleObj = new Module();
$userObj = new User();

$moduleResult = $moduleObj->getAllModules();
$userResult = $userObj->getAllUsers();


?>

<html>
    <head>
        <?php include_once "../includes/bootstrap_css_includes.php"?>
        <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css"/>
        
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

.col-md-3, .col-md-9 {
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
    text-align: center;
}

.table-striped tbody td {
    vertical-align: middle;
    text-align: center;
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

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.btn:hover {
    opacity: 0.85;
}

        </style>
    </head>
    <body>
        <div class="container">
            <?php $pageName="USER MANAGEMENT" ?>
            <?php include_once "../includes/header_row_includes.php";?>
            
            <div class="col-md-3">
                <ul class="list-group">
                    <a href="add-user.php"class="list-group-item">
                        <span class="glyphicon glyphicon-plus"></span> &nbsp;
                        Add user
                    </a>
                    <a href="view-users.php"class="list-group-item">
                        <span class="glyphicon glyphicon-search"></span> &nbsp;
                        View users
                    </a>
                    <a href="user-report.php"class="list-group-item">
                        <span class="glyphicon glyphicon-book"></span> &nbsp;
                        Generate user reports
                    </a>
                </ul>
            </div>
            <div class="col-md-9">
                <?php
                    
                    if(isset($_GET["msg"])){
                        
                        $msg= base64_decode($_GET["msg"]);
                        
                ?>
                    <div class="row">
                        <div class="alert alert-success">
                            <?php echo $msg;?>
                        </div>
                    </div>
                <?php
                    }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped" id="usertable">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($userRow=$userResult->fetch_assoc()){
                                        
                                        $img_path="../images/user_images/";
                                        $user_id=$userRow["user_id"];
                                        $user_id= base64_encode($user_id);
                                        if($userRow["user_image"]==""){
                                            
                                            $img_path=$img_path."user.png";
                                        }else{
                                            $img_path=$img_path.$userRow["user_image"];
                                        }
                                        $status="Active";
                                        if($userRow["user_status"]==0){
                                            
                                            $status="Deactive";
                                        }
                                        
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $img_path;?>" width="60px" height="60px"/>
                                            </td>
                                            <td>
                                                <?php echo $userRow["user_fname"]." ".$userRow["user_lname"];?>
                                            </td>
                                            <td>
                                                <?php echo $userRow["user_email"];?>
                                            </td>
                                            <td 
                                                <?php
                                                if($userRow["user_status"]==1){   
                                                ?>
                                                class="success"
                                                <?php
                                                }elseif ($userRow["user_status"]==0) {

                                                ?>
                                                class="danger"
                                                <?php

                                                }
                                                ?>

                                                ><?php echo $status;?></td>
                                            <td>
                                                <a href="view-user.php?user_id=<?php echo $user_id;?>" class="btn btn-info">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                    &nbsp;
                                                    View
                                                </a>
                                                &nbsp;
                                                <a href="edit-user.php?user_id=<?php echo $user_id?>" class="btn btn-warning">
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                    &nbsp;
                                                    Edit
                                                </a>
                                                
                                                &nbsp;

                                                <?php
                                                if ($userRow["user_status"]==0){
                                                ?>
                                                <a href="../controller/user_controller.php?status=activate&user_id=<?php echo $user_id?>" class="btn btn-success">
                                                    <span class="glyphicon glyphicon-ok"></span>
                                                    &nbsp;
                                                    Activate
                                                </a>
                                                
                                                &nbsp;

                                                <?php
                                                }elseif ($userRow["user_status"]==1) {

                                                ?>
                                                <a href="../controller/user_controller.php?status=deactivate&user_id=<?php echo $user_id?>" class="btn btn-danger">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                    &nbsp;
                                                    De-activate
                                                </a>
                                                &nbsp;
                                                <?php
                                                }
                                                ?>
                                                <a href="../controller/user_controller.php?status=delete&user_id=<?php echo $user_id?>" class="btn btn-danger">
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
            
            $("#usertable").DataTable();
        });
    </script>
</html>

