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

    case "add_user":

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $dob = $_POST["dob"];
        $nic = $_POST["nic"];
        $user_image = $_FILES["user_image"];
        $cno1 = $_POST["cno1"];
        $user_role = $_POST["user_role"];

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

            $user_id = $userObj->addUser($fname, $lname, $email, $password, $dob, $nic, $user_role, $file_name, $cno1);

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
        $user_id = isset($_GET['user_id']) ? base64_decode($_GET['user_id']) : null;

        if (!isset($_SESSION['user'])) {
            echo "<script>alert('Unauthorized access!'); window.location.href = '../view/login.php';</script>";
            exit;
        }

        include_once '../model/user_model.php';
        $current_user_id = $_SESSION['user']['user_id'];
        $userObjCheck = new User();
        $accessibleFunctions = $userObjCheck->getAccessibleFunctionsWithModule($current_user_id);

        $hasDeletePermission = false;

        foreach ($accessibleFunctions as $func) {
            if (
                strtolower($func['function_url']) === 'user_controller.php' &&
                (int)$func['function_id'] === 6 // Delete User
            ) {
                $hasDeletePermission = true;
                break;
            }
        }

        if (!$hasDeletePermission) {
            echo "<script>alert('Access Denied!'); window.location.href = '../view/dashboard.php';</script>";
            exit;
        }

        // Delete the user
        $userObj->deleteUser($user_id);

        $msg = base64_encode("Successfully Deleted !!!");
        echo "<script>window.location.href = '../view/view-users.php?msg=$msg';</script>";
        break;


    case "update_user":

        $user_id = $_POST["user_id"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $dob = $_POST["dob"];
        $nic = $_POST["nic"];
        $cno1 = $_POST["cno1"];
        $user_role = $_POST["user_role"];
        $user_image = $_FILES["user_image"];

        try {
            if ($user_id == "") {
                throw new Exception("User Id Cannot be Empty");
            }
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
                throw new Exception("Mobile No cannot be Empty!!!!");
            }
            if ($user_role == "") {
                throw new Exception("User Role cannot be Empty!!!!");
            }

            $userResult = $userObj->getUser($user_id);
            $userRow = $userResult->fetch_assoc();

            $file_name = "";
            if (isset($_FILES["user_image"])) {

                if ($user_image["name"] != "") {

                    $file_name = time() . "_" . $user_image["name"];
                    $path = "../images/user_images/$file_name";
                    move_uploaded_file($user_image["tmp_name"], $path);
                }
            }

            //update user
            $userObj->UpdateUser($user_id, $fname, $lname, $email, $password, $dob, $nic, $user_role, $file_name, $cno1);

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
