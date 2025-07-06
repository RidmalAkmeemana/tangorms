<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Inventory
{
    public function getActiveItemCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN item_status = '1' THEN 1 END) AS active_item_count
                FROM `item`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getInactiveItemCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN item_status = '0' THEN 1 END) AS inactive_item_count
                FROM `item`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getZeroItemCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                COUNT(CASE 
                    WHEN item_status = '1' AND item_qty = 0 THEN 1 
                END) AS zero_item_count
            FROM `item`";

        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getAllInventories()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT i.*, c.category_name 
            FROM `item` i
            INNER JOIN `categories` c ON i.item_category = c.category_id
            WHERE i.item_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getAllCategory()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM categories WHERE category_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getInventory($item_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT i.*, c.category_name
            FROM item i
            INNER JOIN categories c ON i.item_category = c.category_id 
            WHERE i.item_id = '$item_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function UpdateInventory($item_id, $item_price, $item_qty)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `item` 
            SET item_price = ?, item_qty = ?
            WHERE item_id = ?";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        // Correct order: price, qty, id
        $stmt->bind_param("dii", $item_price, $item_qty, $item_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows > 0;
    }
}
