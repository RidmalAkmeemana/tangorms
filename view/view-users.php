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
                    <a href="generate-user-reports.php"class="list-group-item">
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
                        <table class="table table-striped">
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
    <script src="../js/jquery-3.7.1.js"></script>
</html>
