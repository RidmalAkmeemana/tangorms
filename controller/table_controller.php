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

    case "update_table":
        
         // Get the data from the form
        $table_name = $_POST["table_name"];
        $room_id = $_POST["room"];
        $capacity = $_POST["capacity"];
        $status = $_POST["status"];
         $table_id= $_POST["table_id"];
         
        
        
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