<?php
include '../commons/session.php';
include_once '../model/inventory_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$inventoryObj = new Inventory();
$loginObj = new Login();

switch ($status) {

    case "update_inventory":

        $item_id = $_POST["item_id"];
        $item_price = $_POST["item_price"];
        $item_qty = $_POST["item_qty"];

        try {
            if ($item_id == "") {
                throw new Exception("Item Id Cannot be Empty");
            }

            if ($item_price == "") {
                throw new Exception("Item Price Cannot be Empty");
            }

            if ($item_qty == "") {
                throw new Exception("Item Qty Cannot be Empty");
            }

            $inventoryResult = $inventoryObj->getInventory($item_id);
            $inventoryRow = $inventoryResult->fetch_assoc();

            //update item
            $inventoryObj->UpdateInventory($item_id, $item_price, $item_qty);

            $msg = "Inventory Updated Successfully";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-inventories.php?msg=<?php echo $msg; ?>";
            </script>
        <?php

        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/edit-inventory.php?msg=<?php echo $msg; ?>";
            </script>
<?php
        }

        break;
}
