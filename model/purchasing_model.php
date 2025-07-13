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

    public function updateOrder($receipt_no, $payment_status, $total_paid_amount, $new_due_amount, $new_payment_method)
    {
        $con = $GLOBALS["con"];
        $payment_date = date('Y-m-d H:i:s');
        $last_update = date('Y-m-d H:i:s');

        $sql = "UPDATE orders SET payment_status = ?, paid_amount = ?, due_amount = ?, payment_method = ?, payment_date = ?, last_update = ? WHERE receipt_no = ?";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("sddssss", $payment_status, $total_paid_amount, $new_due_amount, $new_payment_method, $payment_date, $last_update, $receipt_no);

        return $stmt->execute();
    }

    public function getNextPaymentId($receipt_no)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT MAX(payment_id) AS max_id FROM payments WHERE receipt_no = ?");
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return ($row['max_id']) ? $row['max_id'] + 1 : 1;
    }

    public function savePayment($payment_id, $receipt_no, $total_amount, $new_paid_amount, $new_due_amount, $new_payment_method)
    {
        $con = $GLOBALS["con"];
        $balance = 0.00;

        $stmt = $con->prepare("INSERT INTO payments (payment_id, receipt_no, total_amount, paid_amount, balance, due_amount, payment_method)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdddss", $payment_id, $receipt_no, $total_amount, $new_paid_amount, $balance, $new_due_amount, $new_payment_method);
        return $stmt->execute();
    }

    public function getLastPaymentByReceiptNo($receipt_no)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT * FROM payments WHERE receipt_no = ? ORDER BY payment_id DESC LIMIT 1");
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function deleteLastPayment($payment_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("DELETE FROM payments WHERE Id = ?");
        $stmt->bind_param("i", $payment_id);
        return $stmt->execute();
    }

    public function getOrderByReceiptNo($receipt_no)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT * FROM orders WHERE receipt_no = ?");
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateOrderAfterReversal($receipt_no, $newPaidAmount, $newDueAmount, $payment_status)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE orders 
            SET paid_amount = ?, due_amount = ?, payment_status = ?, last_update = NOW()
            WHERE receipt_no = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ddss", $newPaidAmount, $newDueAmount, $payment_status, $receipt_no);
        return $stmt->execute();
    }

    public function getAllPayments()
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT * FROM payments");
        $stmt->execute();
        return $stmt->get_result();
    }
}
