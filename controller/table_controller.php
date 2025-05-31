<?php
include '../commons/session.php';
include_once '../model/user_model.php';
include_once '../model/login_model.php';
include_once '../model/table-model.php';

$tableObj = new RestaurantTable();

if (!isset($_GET["status"])) {
    ?>
    <script>
        window.location = "../view/login.php"; // Or wherever your login page is
    </script>
    <?php
}

$status = $_GET["status"];

switch ($status) {
    case "store":
        // Get the data from the form
        $table_name = $_POST["table_name"];
        $room_id = $_POST["room"];
        $capacity = $_POST["capacity"];
        $status = $_POST["status"];
        //$room_layout = $_FILES["room_layout"];

        // Call the addtables() function in the model
        $tableObj->addtables($table_name, $capacity, $status, $room_id);
            $msg = "Table '$table_name' added successfully!";
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>"; // Redirect to table list
            </script>
            <?php
      
        break;
    case "add_room":
        
        try{
        // Get the data from the form
        $room_name = $_POST["room_name"];
        
        if($room_name==""){
            throw new Exception("Please Enter Room Name");
        }
        
        $room_layout = $_FILES["room_layout"];
        
        if($room_layout['name']==""){
            throw new Exception("Please attache the room image");
        }
        
        $file_name= time() . "_" . $room_layout["name"];
        $path = "../images/layouts/$file_name";
        move_uploaded_file($room_layout["tmp_name"], $path);
            
        
        // Call the addroom() function in the model
        $tableObj->addRoom($room_name, $file_name);
            $msg = "Room '$room_name' added successfully!";
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>"; // Redirect to table list
            </script>
            <?php
        }
        catch (Exception $ex){
            
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/addroom.php?msg=<?php echo $msg; ?>";
            </script>
            <?php
        }
        break;
   
    case "delete":
        $table_id = $_GET['table_id'];
        $tableObj->deleteTable($table_id);

        $msg = "Table Successfully Deleted !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;

    case "update_room":
        
         // Get the data from the form
        $room_name = $_POST["room_id"];
        $room_layout = $_FILES["room_layout"];

        // Call the updateroom() function in the model
        $tableObj->updateRoomLayout($room_id, $room_layout);
            $msg = "Room '$room_name' Updated successfully!";
            $msg = base64_encode($msg);
            ?>
            <script>
                window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>"; // Redirect to table list
            </script>
            <?php
      
        break;
        
        
        //update table
        $tableObj->updateTable($table_id,$table_name, $room_id, $capacity, $status);
        $msg = "Table Successfully Updated !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-tables.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;
    
        
}