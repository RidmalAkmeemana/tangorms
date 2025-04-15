<?php
include '../commons/session.php';
include_once '../model/user_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
    ?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$userObj = new User();
$loginObj = new Login();

switch ($status) {
    case "load_functions":

        $role_id = $_POST["role"];

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
                    <input type="checkbox" name="fun[]" value="<?php echo $fun_row["function_id"]; ?>" checked/>
                    <?php echo $fun_row["function_name"]; ?>
                    <br/>
                    <?php
                }
                ?>
            </div>
                <?php
            }

            break;

        case "add_user":

            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $email = $_POST["email"];
            $dob = $_POST["dob"];
            $nic = $_POST["nic"];
            $cno1 = $_POST["cno1"];
            $cno2 = $_POST["cno2"];
            $user_role = $_POST["user_role"];
            $user_image = $_FILES["user_image"];
            $user_functions = $_POST["fun"];

            try {
                if ($fname == "") {
                    throw new Exception("First Name Cannot be Empty");
                }
                if ($lname == "") {
                    throw new Exception("Last Name cannot be Empty!!!!");
                }
                if ($email == "") {
                    throw new Exception("Email Name cannot be Empty!!!!");
                }
                if ($dob == "") {
                    throw new Exception("Date of Birth cannot be Empty!!!!");
                }
                if ($nic == "") {
                    throw new Exception("NIC cannot be Empty!!!!");
                }
                if ($cno1 == "") {
                    throw new Exception("Mobile No 1 cannot be Empty!!!!");
                }
                if ($cno2 == "") {
                    throw new Exception("Mobile No 2 cannot be Empty!!!!");
                }
                if ($user_role == "") {
                    throw new Exception("User Role cannot be Empty!!!!");
                }

                //uploading image

                $file_name = "";
                if (isset($_FILES["user_image"])) {

                    if ($user_image["name"] != "") {

                        $file_name = time() . "_" . $user_image["name"];
                        $path = "../images/user_images/$file_name";
                        move_uploaded_file($user_image["tmp_name"], $path);
                    }
                }

                // Passing data to the addUser() of the Module page

                $user_id = $userObj->addUser($fname, $lname, $email, $dob, $nic, $user_role, $file_name);

                //creating login account

                if ($user_id > 0) {
                    $loginObj->addUserLogin($user_id, $email, $nic);
                }
                //add user functions

                foreach ($user_functions as $fun_id) {

                    $userObj->addUserFunctions($user_id, $fun_id);
                }
                // add user contact

                $userObj->addUserContact($user_id, $cno1);
                $userObj->addUserContact($user_id, $cno2);

                $msg = "User $fname $lname Successfully Added !! ";
                $msg = base64_encode($msg);
                ?>
            <script>
                window.location = "../view/view-users.php?msg=<?php echo $msg; ?>";
            </script>
            <?php
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/add-user.php?msg=<?php echo $msg; ?>";
            </script>
            <?php
        }


        break;

    //active a user

    case "activate":
        $user_id = $_GET['user_id'];
        $user_id = base64_decode($user_id);
        $userObj->activateUser($user_id);

        $msg = "Successfully Activated !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-users.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;

    case "deactivate":
        $user_id = $_GET['user_id'];
        $user_id = base64_decode($user_id);
        $userObj->deactivateUser($user_id);

        $msg = "Successfully Dectivated !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-users.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;

    case "delete":
        $user_id = $_GET['user_id'];
        $user_id = base64_decode($user_id);
        $userObj->deleteUser($user_id);

        $msg = "Successfully Deleted !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-users.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;

    case "update_user":

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $dob = $_POST["dob"];
        $nic = $_POST["nic"];
        $cno1 = $_POST["cno1"];
        $cno2 = $_POST["cno2"];
        $user_role = $_POST["user_role"];
        $user_image = $_FILES["user_image"];
        $user_functions = $_POST["fun"];
        $user_id = $_POST["user_id"];

        try {
            if ($fname == "") {
                throw new Exception("First Name Cannot be Empty");
            }
            if ($lname == "") {
                throw new Exception("Last Name cannot be Empty!!!!");
            }
            if ($email == "") {
                throw new Exception("Email Name cannot be Empty!!!!");
            }
            if ($dob == "") {
                throw new Exception("Date of Birth cannot be Empty!!!!");
            }
            if ($nic == "") {
                throw new Exception("NIC cannot be Empty!!!!");
            }
            if ($cno1 == "") {
                throw new Exception("Mobile No 1 cannot be Empty!!!!");
            }
            if ($cno2 == "") {
                throw new Exception("Mobile No 2 cannot be Empty!!!!");
            }
            if ($user_role == "") {
                throw new Exception("User Role cannot be Empty!!!!");
            }

            $userResult = $userObj->getUser($user_id);
            $userRow = $userResult->fetch_assoc();
            $prev_image = $userRow["user_image"];

            if (isset($user_image)) {

                if ($user_image["name"] != "") {

                    //upload new image

                    $img = time() . "_" . $user_image["name"];
                    $path = "../images/user_images/";
                    move_uploaded_file($user_image["tmp_name"], $path . "$img");

                    //remove previous image
                    if (file_exists($path . $prev_image) && $prev_image != "") {
                        unlink($path . $prev_image);
                    }
                } else {
                    $img = $prev_image;
                }
            }

            //update user
            $userObj->UpdateUser($fname, $lname, $email, $dob, $nic, $user_role, $img, $user_id);

            //delete existing contacts
            $userObj->removeUserContact($user_id);

            //add new contacts
            $userObj->addUserContact($user_id, $cno1);
            $userObj->addUserContact($user_id, $cno2);

            // deleting existing functions

            $userObj->removeUserFunctions($user_id);

            //add new user functions

            foreach ($user_functions as $fun_id) {

                $userObj->addUserFunctions($user_id, $fun_id);
            }
            
            $msg = "User Updated Successfully";
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/view-users.php?msg=<?php echo $msg; ?>";
            </script>
            <?php
            
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/edit-user.php?msg=<?php echo $msg; ?>";
            </script>
            <?php
        }


        break;
}
      
        
        
        
        
    



