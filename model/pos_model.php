<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class POS
{
    public function getInvoiceNo()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT `value` FROM `temp_invoice` LIMIT 1"; // narrow query to just what you need
        $result = $con->query($sql) or die($con->error);

        if ($row = $result->fetch_assoc()) {
            // Replace 'value' with actual column name if different
            $rawValue = isset($row['value']) ? $row['value'] : 1;
            return 'TANGOREC' . str_pad($rawValue, 5, '0', STR_PAD_LEFT);
        } else {
            return 'TANGOREC00001';
        }
    }

    public function getItems($category_id)
    {
        $con = $GLOBALS["con"];
        $category_id = (int)$category_id; // Security: force integer
        $sql = "SELECT * FROM `item` WHERE item_category = $category_id AND item_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}
