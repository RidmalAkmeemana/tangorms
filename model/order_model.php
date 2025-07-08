<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Order
{
    // Get order details by receipt number
    public function getAllOrders()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                o.*, 
                c.customer_name, 
                t.table_name 
            FROM 
                orders o
            LEFT JOIN 
                customer c ON o.customer_id = c.customer_id
            LEFT JOIN 
                `table` t ON o.table_id = t.table_id";

        $result = $con->query($sql);

        if (!$result) {
            die("Query failed: " . $con->error);
        }

        return $result; // return result set (not fetch_assoc) for multiple rows
    }
}
