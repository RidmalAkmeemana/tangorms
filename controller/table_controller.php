<?php
include '../commons/session.php';
include_once '../model/table_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$tableObj = new Table();
$loginObj = new Login();

switch ($status) {

    case "add_table":

        $table_name = $_POST["table_name"];
        $seat_count = $_POST["seat_count"];
        $table_status = $_POST["table_status"];
        $room_id = $_POST["room_id"];

        try {
            if ($table_name == "") {
                throw new Exception("Table Name Cannot be Empty");
            }

            if ($seat_count == "") {
                throw new Exception("Seat Count Cannot be Empty");
            }

            if ($table_status == "") {
                throw new Exception("Status Cannot be Empty");
            }

            if ($room_id == "") {
                throw new Exception("Room Cannot be Empty");
            }

            // Passing data to the addRole() of the Module page

            $table_id = $tableObj->addTable($table_name, $seat_count, $table_status, $room_id);

            $msg = "$table_name Successfully Added !! ";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/add-table.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        }


        break;

    case "delete":
        $role_id = $_GET['role_id'];
        $role_id = base64_decode($role_id);
        $roleObj->deleteRole($role_id);

        $msg = "Successfully Deleted !!!";
        $msg = base64_encode($msg);
    ?>
        <script>
            window.location = "../view/view-roles.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;

    case "update_table":

        $table_id = $_POST["table_id"];
        $table_name = $_POST["table_name"];
        $seat_count = $_POST["seat_count"];
        $table_status = $_POST["table_status"];
        $room_id = $_POST["room_id"];

        try {
            if ($table_id == "") {
                throw new Exception("Table Id Cannot be Empty");
            }
            if ($table_name == "") {
                throw new Exception("Table Name Cannot be Empty");
            }
            if ($seat_count == "") {
                throw new Exception("Capacity Cannot be Empty");
            }
            if ($table_status == "") {
                throw new Exception("Table Status Cannot be Empty");
            }
            if ($room_id == "") {
                throw new Exception("Room Cannot be Empty");
            }

            $tableResult = $tableObj->getTable($table_id);
            $tableRow = $tableResult->fetch_assoc();
            //update table
            $tableObj->UpdateTable($table_id, $table_name, $seat_count, $table_status, $room_id);

            $msg = "Table Updated Successfully";
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>";
            </script>
        <?php

        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/edit-table.php?msg=<?php echo $msg; ?>";
            </script>
<?php
        }


        break;
}
