<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Purchasing
{
    public function getOrderStatusCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN payment_status = 'Fully Paid' THEN 1 END) AS fully_paid_count,
                    COUNT(CASE WHEN payment_status = 'Partially Paid' THEN 1 END) AS partially_paid_count,
                    COUNT(CASE WHEN payment_status = 'Unpaid' THEN 1 END) AS unpaid_count
                FROM `orders`";

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
                `table` t ON o.table_id = t.table_id";

        $result = $con->query($sql);

        if (!$result) {
            die("Query failed: " . $con->error);
        }

        return $result;
    }

    public function getAllPaidOrders()
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
                o.payment_status IN ('Fully Paid', 'Partially Paid')";

        $result = $con->query($sql);

        if (!$result) {
            die("Query failed: " . $con->error);
        }

        return $result;
    }

    public function getPaymentsByReceiptNo($receipt_no)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT * FROM payments WHERE receipt_no = ?");
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        return $stmt->get_result(); // Return result to loop over
    }

    public function updateOrder($receipt_no, $new_payment_status, $new_paid_amount, $new_due_amount, $new_payment_method)
    {
        $con = $GLOBALS["con"];
        $payment_date = date('Y-m-d H:i:s');

        $sql = "UPDATE orders 
            SET payment_status = ?, 
                paid_amount = ?, 
                due_amount = ?, 
                payment_method = ?, 
                payment_date = ?  
            WHERE receipt_no = ?";

        $stmt = $con->prepare($sql);

        // Correct data types: s = string, d = double
        $stmt->bind_param(
            "ddssss",
            $new_paid_amount,
            $new_due_amount,
            $new_payment_status,
            $new_payment_method,
            $payment_date,
            $receipt_no
        );

        return $stmt->execute();
    }



    // public function updateOrderStatus($receipt_no, $order_status, $reason = null)
    // {
    //     $con = $GLOBALS["con"];
    //     $last_update = date('Y-m-d H:i:s');

    //     $sql = "UPDATE orders SET order_status = ?, reason = ?, last_update = ? WHERE receipt_no = ?";
    //     $stmt = $con->prepare($sql);

    //     if (!$stmt) {
    //         die("Prepare failed: " . $con->error);
    //     }

    //     $stmt->bind_param("ssss", $order_status, $reason, $last_update, $receipt_no);

    //     return $stmt->execute();
    // }
}
