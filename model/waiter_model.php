<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Waiter
{
    public function getOrderStatusCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN order_status = 'Pending' THEN 1 END) AS pending_count,
                    COUNT(CASE WHEN order_status = 'Preparing' THEN 1 END) AS preparing_count,
                    COUNT(CASE WHEN order_status = 'Ready' THEN 1 END) AS ready_count,
                    COUNT(CASE WHEN order_status = 'Served' THEN 1 END) AS served_count,
                    COUNT(CASE WHEN order_status = 'Completed' THEN 1 END) AS completed_count,
                    COUNT(CASE WHEN order_status = 'Rejected' THEN 1 END) AS rejected_count
                FROM `orders` WHERE order_type IN ('Dine-In', 'Take-Away')";

        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

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
                `table` t ON o.table_id = t.table_id 
            WHERE 
                o.order_status IN ('Ready', 'Served', 'Completed', 'Rejected') AND o.order_type IN ('Dine-In', 'Take-Away')";

        $result = $con->query($sql);

        if (!$result) {
            die("Query failed: " . $con->error);
        }

        return $result;
    }


    public function updateOrderStatus($receipt_no, $order_status, $reason = null)
    {
        $con = $GLOBALS["con"];
        $last_update = date('Y-m-d H:i:s');

        $sql = "UPDATE orders SET order_status = ?, reason = ?, last_update = ? WHERE receipt_no = ?";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("ssss", $order_status, $reason, $last_update, $receipt_no);

        return $stmt->execute();
    }

    // Fetch order by receipt number
    public function getOrderByReceiptNo($receipt_no)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM orders WHERE receipt_no = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update table status
    public function updateTableStatus($table_id, $status)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `table` SET table_status = ? WHERE table_id = ?";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error); // DEBUG
        }

        $stmt->bind_param("si", $status, $table_id);
        return $stmt->execute();
    }
}
