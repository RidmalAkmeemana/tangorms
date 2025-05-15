<?php

include '../commons/session.php';
include_once '../model/user_model.php';

//get user information from session
$userrow=$_SESSION["user"];

$userObj = new User();

$roleResult = $userObj->getAllRoles();

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
            <?php $pageName="Add User" ?>
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
            <form action="../controller/user_controller.php?status=add_user" method="post" enctype="multipart/form-data">
                <div class = "col-md-9">
        
                     <div class="row">

                        <div class="col-md-6 col-md-offset-3" id="msg">

                        </div>
                         <?php 
                        if(isset($_GET['msg'])){
                            
                        ?>
                        <div class="col-md-6 col-md-offset-3 alert alert-danger">
                        <?php 
                            $msg = base64_decode($_GET['msg']);
                            echo $msg;
                        ?>
                        </div>
                        <?php
                        }
                        ?> 
                  
                    </div>
                    
                    <div class="row">
                        <div class = "col-md-3">
                            <label class ="control-lebel">First Name</label>
                        </div>
                        <div class = "col-md-3">
                            <input type=" text" class = "form-control" name = "fname" id="fname"/>
                        </div>
                         <div class = "col-md-3">
                            <label class ="control-lebel">Last Name</label>
                        </div>
                        <div class = "col-md-3">
                            <input type=" text" class = "form-control" name = "lname" id="lname"/>
                        </div>
                    </div>
                          <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                          </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Email</label>
                        </div>
                        <div class="col-md-3">
                            <input type="email" class="form-control" name="email" id="email"/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Date of Birth</label>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="dob" id="dob"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">NIC</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="nic" id="nic"/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Image</label>
                        </div>
                        <div class="col-md-3">
                            <input type="file" class="form-control" name="user_image" id="user_image" onchange="displayImage(this);"/>
                            <br/>
                            <img id="img_prev" style=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Contact No 1</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="cno1" id="cno1"/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Contact No 2</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="cno2" id="cno2"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                             &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">User Role</label>
                        </div>
                        <div class="col-md-3">
                            <select  name="user_role" id="user_role" class="form-control" required="required">
                                <option>-----------------------------------------</option>
                                <?php 
                                    while($roleRow=$roleResult->fetch_assoc())
                                    {
                                ?>
                                <option value="<?php echo $roleRow["role_id"]; ?>">
                                    <?php echo $roleRow["role_name"];?>
                                </option>
                                <?php
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12"> &nbsp; </div>
                    </div>
                    <div class="row">
                        <div id="display_functions">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                             &nbsp;
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <input type="submit" class="btn btn-primary" value="Submit"/>
                            <input type="reset" class="btn btn-danger" value="Reset"/>
                        </div>
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


