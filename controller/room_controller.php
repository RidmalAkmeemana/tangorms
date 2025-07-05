<?php
include '../commons/session.php';
include_once '../model/room_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$roomObj = new Room();
$loginObj = new Login();

switch ($status) {

    case "add_room":

        $room_name = $_POST["room_name"];
        $room_layout = $_FILES["room_layout"];

        try {
            if ($room_name == "") {
                throw new Exception("Table Name Cannot be Empty");
            }

            if ($room_layout == "") {
                throw new Exception("Seat Count Cannot be Empty");
            }

            //uploading image

            $file_name = "";
            if (isset($_FILES["room_layout"])) {

                if ($room_layout["name"] != "") {

                    $file_name = time() . "_" . $user_image["name"];
                    $path = "../images/layouts/$file_name";
                    move_uploaded_file($room_layout["tmp_name"], $path);
                }
            }

            // Passing data to the addRole() of the Module page

            $room_id = $roomObj->addRoom($room_name, $file_name);

            $msg = "$table_name Successfully Added !! ";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-rooms.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/add-room.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        }


        break;

    case "activate":
        $room_id = $_GET['room_id'];
        $room_id = base64_decode($room_id);
        $roomObj->activateRoom($room_id);

        $msg = "Successfully Activated !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-rooms.php?msg=<?php echo $msg; ?>";
        </script>
    <?php
        break;

    case "deactivate":
        $room_id = $_GET['room_id'];
        $room_id = base64_decode($room_id);
        $roomObj->deactivateRoom($room_id);

        $msg = "Successfully Dectivated !!!";
        $msg = base64_encode($msg);
    ?>
        <script>
            window.location = "../view/view-rooms.php?msg=<?php echo $msg; ?>";
        </script>
    <?php
        break;

    case "delete":
    session_start();

    // Ensure user is logged in
    if (!isset($_SESSION['user'])) {
        echo "<script>alert('Unauthorized access!'); window.location.href = '../view/login.php';</script>";
        exit;
    }

    // Validate room_id parameter
    if (!isset($_GET['room_id'])) {
        echo "<script>alert('Missing Room ID!'); window.location.href = '../view/view-rooms.php';</script>";
        exit;
    }

    $room_id = base64_decode($_GET['room_id']);
    $current_user_id = $_SESSION['user']['user_id'];

    // Load user model to check permissions
    include_once '../model/user_model.php';
    $userObj = new User();
    $accessibleFunctions = $userObj->getAccessibleFunctionsWithModule($current_user_id);

    // Check for delete permission (assuming function_id 26 = delete room)
    $hasDeletePermission = false;
    foreach ($accessibleFunctions as $func) {
        if (
            strtolower($func['function_url']) === 'room_controller.php' &&
            (int)$func['function_id'] === 26
        ) {
            $hasDeletePermission = true;
            break;
        }
    }

    // If no permission
    if (!$hasDeletePermission) {
        echo "<script>alert('Access Denied!'); window.location.href = '../view/dashboard.php';</script>";
        exit;
    }

    // Proceed with deletion
    include_once '../model/room_model.php'; // Make sure this file exists
    $roomObj = new Room(); // Use correct model

    try {
        $roomObj->deleteRoom($room_id); // Ensure this function updates room_status or actually deletes
        $msg = base64_encode("Room deleted successfully.");
        echo "<script>window.location.href = '../view/view-rooms.php?msg=$msg';</script>";
    } catch (Exception $e) {
        $error = base64_encode("Error deleting room: " . $e->getMessage());
        echo "<script>window.location.href = '../view/view-rooms.php?msg=$error';</script>";
    }

    break;


    case "update_room":

        $room_id = $_POST["room_id"];
        $room_name = $_POST["room_name"];
        $room_layout = $_FILES["room_layout"];

        try {
            if ($room_id == "") {
                throw new Exception("Room Cannot be Empty");
            }

            if ($room_name == "") {
                throw new Exception("Room Name be Empty");
            }

            if ($room_layout == "") {
                throw new Exception("Room Layout be Empty");
            }

            $roomResult = $roomObj->getRoom($room_id);
            $roomRow = $roomResult->fetch_assoc();

            //uploading image

            $file_name = "";
            if (isset($_FILES["room_layout"])) {

                if ($room_layout["name"] != "") {

                    $file_name = time() . "_" . $room_layout["name"];
                    $path = "../images/layouts/$file_name";
                    move_uploaded_file($room_layout["tmp_name"], $path);
                }
            }
            
            //update room
            $roomObj->UpdateRoom($room_id, $room_name, $file_name);

            $msg = "Room Updated Successfully";
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/view-rooms.php?msg=<?php echo $msg; ?>";
            </script>
        <?php

        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/edit-room.php?msg=<?php echo $msg; ?>";
            </script>
<?php
        }


        break;
}
