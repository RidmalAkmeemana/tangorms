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

    public function getTables()
    {
        $con = $GLOBALS["con"];

        $sql = "SELECT * FROM `table`
                WHERE table_status = 'Vacant'";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    // Save Order to `orders` table
    public function saveOrder($receipt_no, $customer_id, $payment_status, $sub_total_amount, $discount, $total_amount, $paid_amount, $balance, $due_amount, $payment_method, $order_type, $table_id, $order_priority)
    {
        $con = $GLOBALS["con"];
        $order_status = "Pending";

        // Set payment_date to NULL if Unpaid
        $payment_date = ($payment_status === 'Unpaid') ? null : date('Y-m-d H:i:s');
        $last_update = date('Y-m-d H:i:s');

        // Set table_id to NULL if order type is not Dine-In
        if ($order_type !== 'Dine-In') {
            $table_id = null;
        }

        $stmt = $con->prepare("INSERT INTO orders (
        receipt_no, customer_id, payment_status, sub_total_amount, discount, total_amount, paid_amount, balance,
        due_amount, payment_method, order_type, order_status, table_id, order_priority, payment_date, last_update
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind all 16 values, allowing nulls for table_id and payment_date
        $stmt->bind_param(
            "sisddddddsssisss",
            $receipt_no,
            $customer_id,
            $payment_status,
            $sub_total_amount,
            $discount,
            $total_amount,
            $paid_amount,
            $balance,
            $due_amount,
            $payment_method,
            $order_type,
            $order_status,
            $table_id,
            $order_priority,
            $payment_date,
            $last_update
        );

        return $stmt->execute();
    }



    // Save items to `order_item` table
    public function saveOrderItem($receipt_no, $item_code, $item_name, $item_price, $item_qty, $total_price)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("INSERT INTO order_item (receipt_no, item_code, item_name, item_price, item_qty, total_price)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddd", $receipt_no, $item_code, $item_name, $item_price, $item_qty, $total_price);
        return $stmt->execute();
    }

    // Subtract sold quantity from item table
    public function updateItemQty($item_code, $qty_sold)
    {
        $con = $GLOBALS["con"];
        // Ensure quantity will not go below 0
        $stmt = $con->prepare("UPDATE item 
                               SET item_qty = CASE 
                                   WHEN item_qty >= ? THEN item_qty - ? 
                                   ELSE item_qty 
                               END 
                               WHERE item_code = ?");
        $stmt->bind_param("dds", $qty_sold, $qty_sold, $item_code);
        return $stmt->execute();
    }

    // Set table_status to Seated
    public function vacateTable($table_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("UPDATE `table` SET table_status = 'Seated' WHERE table_id = ?");
        $stmt->bind_param("i", $table_id);
        return $stmt->execute();
    }

    // Save to `payments` table
    public function savePayment($payment_id, $receipt_no, $total_amount, $paid_amount, $balance, $due_amount, $payment_method)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("INSERT INTO payments (payment_id, receipt_no, total_amount, paid_amount, balance, due_amount, payment_method)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdddss", $payment_id, $receipt_no, $total_amount, $paid_amount, $balance, $due_amount, $payment_method);
        return $stmt->execute();
    }

    // Get next payment ID
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

    // Update Invoice Number
    public function updateInvoiceNo()
    {
        $con = $GLOBALS["con"];
        return $con->query("UPDATE temp_invoice SET value = value + 1");
    }

    // Get order details by receipt number
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
    public function getOrderItemsByReceiptNo($receipt_no)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("SELECT * FROM order_item WHERE receipt_no = ?");
        $stmt->bind_param("s", $receipt_no);
        $stmt->execute();
        return $stmt->get_result(); // Return result to loop over
    }

    public function updateOrderStatus($receipt_no, $order_status, $reason)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE orders SET order_status = ?, reason = ? WHERE receipt_no = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $order_status, $reason, $receipt_no);
        return $stmt->execute();
    }
}
