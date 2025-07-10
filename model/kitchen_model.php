<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Kitchen
{
    public function getOrderStatusCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN order_status = 'Pending' THEN 1 END) AS pending_count,
                    COUNT(CASE WHEN order_status = 'Preparing' THEN 1 END) AS preparing_count,
                    COUNT(CASE WHEN order_status = 'Ready' THEN 1 END) AS ready_count,
                    COUNT(CASE WHEN order_status = 'Served' THEN 1 END) AS served_count,
                    COUNT(CASE WHEN order_status = 'Delivering' THEN 1 END) AS delivering_count,
                    COUNT(CASE WHEN order_status = 'Completed' THEN 1 END) AS completed_count,
                    COUNT(CASE WHEN order_status = 'Rejected' THEN 1 END) AS rejected_count,
                    COUNT(CASE WHEN order_status = 'Canceled' THEN 1 END) AS canceled_count
                FROM `orders`";
                
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
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
}
