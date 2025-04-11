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
                    <a href="generate-user-reports.php"class="list-group-item">
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


