<?php
include '../commons/session.php';
include_once '../model/pos_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$posObj = new POS();
$loginObj = new Login();

switch ($status) {

    case "submit_order":

        $room_name = $_POST["room_name"];
        $room_layout = $_FILES["room_layout"];

        try {
            if ($room_name == "") {
                throw new Exception("Table Name Cannot be Empty");
            }

            if ($room_layout == "") {
                throw new Exception("Room Layout Cannot be Empty");
            }

            //uploading image

            $file_name = "";
            if (isset($_FILES["room_layout"])) {

                if ($room_layout["name"] != "") {

                    $file_name = time() . "_" . $room_layout["name"];
                    $path = "../images/layouts/$file_name";
                    move_uploaded_file($room_layout["tmp_name"], $path);
                }
            }

            // Passing data to the addRole() of the Module page

            $room_id = $roomObj->addRoom($room_name, $file_name);

            $msg = "$room_name Successfully Added !! ";
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
}


