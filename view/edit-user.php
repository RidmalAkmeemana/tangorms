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
                            <input type=" text" class = "form-control" name = "fname" id="fname" value="<?php echo $userRow["user_fname"];?>"/>
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
                        <div id="display_functions">
                           <div class="col-md-3">
                            <label class="control-label">User Role</label>
                            </div>  
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
                            
                                //This section re-used from user_controller.php's load_functions case
                                $role_id = $userRow["user_role"];
        
                                $moduleResult=$userObj->getRoleModules($role_id);

                                while ($module_row=$moduleResult->fetch_assoc())
                                {
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
                                                    while($fun_row=$functionResult->fetch_assoc()){
                                                        ?>
                                                        <input type="checkbox" name="fun[]" value="<?php echo $fun_row["function_id"];?>" 
                                                               
                                                               <?php
                                                               if(in_array($fun_row["function_id"],$functionArray)){
                                                               ?>
                                                               
                                                               checked
                                                               
                                                               <?php
                                                               }
                                                               ?>
                                                               
                                                               />
                                                        <?php echo $fun_row["function_name"];?>
                                                        <br/>
                                                        <?php
                                                    }
                                                ?>
                                        </div>
                                    <?php
                                }
                                
                                //Above section re-used from user_controller.php's load_functions case
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


