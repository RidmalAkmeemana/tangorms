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

    public function getOrderByReceiptNo($receipt_no)
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
                    `table` t ON o.table_id = t.table_id
                WHERE 
                    o.receipt_no = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Get order items by receipt number
    public function getItemsByReceiptNo($receipt_no)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT * FROM order_item WHERE receipt_no = ?");
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        return $stmt->get_result(); // Return result to loop over
    }
}
