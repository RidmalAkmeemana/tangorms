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

$user_id=$_GET["user_id"];
$user_id= base64_decode($user_id);

$userResult = $userObj->getUser($user_id);
$userdetailrow = $userResult->fetch_assoc();

$contactResult=$userObj->getUserContact($user_id);
$contactRow1=$contactResult->fetch_assoc();
$contactRow2=$contactResult->fetch_assoc();

//get user information from session
$userrow=$_SESSION["user"];

$moduleObj = new Module();

$moduleResult = $moduleObj->getAllModules();

//getting already assigned user functions
$functionArray = array();
$userFunctionResult=$userObj->getUserFunctions($user_id);

while($fun_row=$userFunctionResult->fetch_assoc()){
   
    array_push($functionArray,$fun_row["function_id"]);
}

?>

<html>
    <head>
        <?php include_once "../includes/bootstrap_css_includes.php"?>
    </head>
    <body>
        <div class="container">
            <?php $pageName="USER PROFILE" ?>
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
                        <tbody>
                            <!-- Stripe 1: Basic Details -->
                            <tr>
                                <td rowspan="4" style="width: 220px;">
                                    <?php
                                        $img = $userdetailrow["user_image"];
                                        if ($img == "") {
                                            $img = "user.png";
                                        }
                                    ?>
                                    <img src="../images/user_images/<?php echo $img; ?>" width="200px" height="250px" />
                                </td>
                                <td><b>First Name:</b> <?php echo $userdetailrow["user_fname"]; ?></td>
                                <td><b>Last Name:</b> <?php echo $userdetailrow["user_lname"]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Email:</b> <?php echo $userdetailrow["user_email"]; ?></td>
                            </tr>
                            <tr>
                                <td><b>Contact 01:</b> <?php echo $contactRow1["contact_number"]; ?></td>
                            
                            
                                <td><b>Contact 02:</b> <?php echo $contactRow2["contact_number"]; ?></td>
                            </tr>
                            <tr>
                               
                                <td><b>Date of Birth:</b> <?php echo $userdetailrow["user_dob"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><b>NIC:</b> <?php echo $userdetailrow["user_nic"]; ?></td>
                                
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>User Role:</b> <?php echo $userdetailrow["role_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                </td>
                                
                            </tr>
                             <tr>
                                <td colspan="2">
                                    <b>User Permissions:</b> 
                                    
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div id="display_functions">
                            <?php
                            
                                //This section re-used from user_controller.php's load_functions case
                                $role_id = $userdetailrow["user_role"];
        
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
                                            <input type="checkbox" name="fun[]" value="<?php echo $fun_row["function_id"];?>"  onclick="return false;" 
                                                               
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
                      
            </div>
    </body>
    <script src="../js/jquery-3.7.1.js"></script>
</html>
