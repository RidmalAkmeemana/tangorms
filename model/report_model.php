<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Report
{
    public function getTotalSalesAmount()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    SUM(total_amount) AS total_sales,
                    SUM(paid_amount) AS total_received,
                    SUM(due_amount) AS total_outstanding
                FROM `orders`
                WHERE order_type IN ('Dine-In', 'Take-Away', 'Delivery') 
                  AND order_status = 'Completed'";

        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getFilteredSalesReport($receipt_no, $payment_status, $payment_method, $order_type, $from_date, $to_date)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM orders WHERE 1=1";
        $params = [];
        $types = "";

        if ($receipt_no !== 'All') {
            $sql .= " AND receipt_no = ?";
            $params[] = $receipt_no;
            $types .= "s";
        }

        if ($payment_status !== 'All') {
            $sql .= " AND payment_status = ?";
            $params[] = $payment_status;
            $types .= "s";
        }

        if ($payment_method !== 'All') {
            $sql .= " AND payment_method = ?";
            $params[] = $payment_method;
            $types .= "s";
        }

        if ($order_type !== 'All') {
            $sql .= " AND order_type = ?";
            $params[] = $order_type;
            $types .= "s";
        }

        if (!empty($from_date)) {
            $sql .= " AND DATE(invoice_date) >= ?";
            $params[] = $from_date;
            $types .= "s";
        }

        if (!empty($to_date)) {
            $sql .= " AND DATE(invoice_date) <= ?";
            $params[] = $to_date;
            $types .= "s";
        }

        $stmt = $con->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
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

    public function getAllReceiptNo()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT DISTINCT receipt_no FROM orders ORDER BY receipt_no DESC";
        return $con->query($sql);
    }

    public function getAllCustomers()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT DISTINCT customer_name FROM customer ORDER BY customer_name DESC";
        return $con->query($sql);
    }

    public function getCustomerOutstandingReport($customer_name, $from_date, $to_date)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT o.receipt_no, c.customer_name, o.paid_amount, o.due_amount, o.invoice_date
            FROM orders o
            LEFT JOIN customer c ON o.customer_id = c.customer_id
            WHERE o.order_status = 'Completed'
              AND DATE(o.invoice_date) BETWEEN ? AND ?";

        $params = [$from_date, $to_date];
        $types = "ss";

        if ($customer_name !== 'All') {
            $sql .= " AND c.customer_name = ?";
            $params[] = $customer_name;
            $types .= "s";
        }

        $stmt = $con->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getFilteredPaymentReport($receipt_no, $payment_method, $from_date, $to_date)
{
    $con = $GLOBALS["con"];

    $sql = "SELECT 
                payment_id,
                receipt_no,
                paid_amount,
                payment_method,
                payment_date
            FROM payments
            WHERE DATE(payment_date) BETWEEN ? AND ?";

    $params = [$from_date, $to_date];
    $types = "ss";

    if ($receipt_no !== 'All') {
        $sql .= " AND receipt_no = ?";
        $params[] = $receipt_no;
        $types .= "s";
    }

    if ($payment_method !== 'All') {
        $sql .= " AND payment_method = ?";
        $params[] = $payment_method;
        $types .= "s";
    }

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result();
}

}
