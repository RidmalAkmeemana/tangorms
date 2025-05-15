<?php

include '../commons/session.php';
include_once '../model/user_model.php';

//get user information from session
$userrow=$_SESSION["user"];

$userObj = new User();

$roleResult = $userObj->getAllRoles();

$user_id= base64_decode($_GET["user_id"]);
$userResult = $userObj->getUser($user_id);

$userRow = $userResult->fetch_assoc();

$contactResult=$userObj->getUserContact($user_id);
$contactRow1=$contactResult->fetch_assoc();
$contactRow2=$contactResult->fetch_assoc();

$userFunctionResult = $userObj->getUserFunctions($user_id);

$functionArray = array();

while($function_row=$userFunctionResult->fetch_assoc()){
    
    array_push($functionArray,$function_row["function_id"]);
}
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
            <form action="../controller/user_controller.php?status=update_user" method="post" enctype="multipart/form-data">
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
                            <input type=" text" class = "form-control" name = "fname" id="fname" value="<?php echo $userRow["user_fname"];?>"/>
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
                        </div>
                         <div class = "col-md-3">
                            <label class ="control-lebel">Last Name</label>
                        </div>
                        <div class = "col-md-3">
                            <input type=" text" class = "form-control" name = "lname" id="lname" value="<?php echo $userRow["user_lname"];?>"/>
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
                            <input type="email" class="form-control" name="email" id="email"  value="<?php echo $userRow["user_email"];?>"/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Date of Birth</label>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $userRow["user_dob"];?>"/>
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
                            <input type="text" class="form-control" name="nic" id="nic" value="<?php echo $userRow["user_nic"];?>"/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Image</label>
                        </div>
                        <div class="col-md-3">
                            <input type="file" class="form-control" name="user_image" id="user_image" onchange="displayImage(this);"/>
                            <br/>
                            <?php 
                                
                                if($userRow["user_image"]!=""){
                                    
                                    $image=$userRow["user_image"];
                            ?>
                            <img id="img_prev" style="" src="../images/user_images/<?php echo $image?>" width="60px" height="60px"/>
                            <?php
                                }
                            ?>
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
                            <input type="text" class="form-control" name="cno1" id="cno1" 
                                   
                                   <?php
                                   if($contactRow1!=null){
                                   ?>
                                   
                                   value="<?php echo $contactRow1['contact_number'];?>"
                                   
                                   <?php
                                   }
                                   ?>
                                   />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Contact No 2</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="cno2" id="cno2" 
                                   <?php
                                   if($contactRow2!=null){
                                   ?>
                                   value="<?php echo $contactRow2['contact_number'];?>"
                                   
                                   <?php
                                   }
                                   ?>
                                   />
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
                                <option value="">--------</option>
                                <?php 
                                    while($roleRow=$roleResult->fetch_assoc())
                                    {
                                ?>
                                <option value="<?php echo $roleRow["role_id"]; ?>"
                                        
                                        <?php
                                            
                                            if($roleRow["role_id"]==$userRow["user_role"]){
                                        ?>
                                        
                                        selected
                                        
                                        <?php
                                            }

                                        ?>
                                        
                                        >
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
                            <?php
                            $role_id = $userRow["user_role"];

                            $moduleResult = $userObj->getRoleModules($role_id);

                            while ($module_row = $moduleResult->fetch_assoc()) {
                                $module_id = $module_row["module_id"];
                                $functionResult = $userObj->getModuleFunctions($module_id);
                                ?>
                                <div class="col-md-4">
                                    <h4>
                                        <?php
                                        echo $module_row["module_name"];
                                        echo "</br>";
                                        ?>
                                    </h4>
                                        <?php
                                        while ($fun_row = $functionResult->fetch_assoc()) {
                                            ?>
                                        <input type="checkbox" name="fun[]" value="<?php echo $fun_row["function_id"]; ?>" 
                                               <?php
                                               for($i=0; $i<count($functionArray);$i++){
                                                   if($functionArray[$i]==$fun_row["function_id"]){
                                                        ?>
                                                        checked
                                                        <?php
                                                   }
                                               }
                                               ?>
                                          />
                                        <?php echo $fun_row["function_name"]; ?>
                                        <br/>
                                        <?php
                                    }
                                    ?>
                                </div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
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
        </dive 
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


