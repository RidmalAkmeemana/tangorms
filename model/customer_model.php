<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Customer
{

    public function getActiiveCustomers()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN customer_status = '1' THEN 1 END) AS active_customer_count
                FROM `customer`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getInactiiveCustomers()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN customer_status = '0' THEN 1 END) AS inactive_customer_count
                FROM `customer`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function addCustomer($customer_nic, $customer_name, $customer_mobile, $customer_address)
    {
        $con = $GLOBALS["con"];

        // Check for duplicate NIC
        $checkStmt = $con->prepare("SELECT customer_id FROM `customer` WHERE customer_nic = ?");
        $checkStmt->bind_param("s", $customer_nic);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            echo "<script>alert('Customer already exists!'); window.history.back();</script>";
            exit;
        }

        $checkStmt->close();

        // Prepare insert
        $stmt = $con->prepare("
        INSERT INTO `customer` (customer_nic, customer_name, customer_mobile, customer_address, customer_status)
        VALUES (?, ?, ?, ?, 1)
    ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        // If address is null, pass as NULL
        if ($customer_address === null) {
            $stmt->bind_param("ssss", $customer_nic, $customer_name, $customer_mobile, $customer_address); // PHP allows null string
        } else {
            $stmt->bind_param("ssss", $customer_nic, $customer_name, $customer_mobile, $customer_address);
        }

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $customer_id = $stmt->insert_id;
        $stmt->close();

        return $customer_id;
    }



    public function getAllCustomers()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM customer WHERE customer_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function activate($customer_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE customer SET customer_status='1' WHERE customer_id ='$customer_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deactivate($customer_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE customer SET customer_status='0' WHERE customer_id ='$customer_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getCustomer($customer_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function UpdateCustomer($customer_nic, $customer_name, $customer_mobile, $customer_address, $customer_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `customer` 
            SET customer_nic = ?, customer_name = ?, customer_mobile = ?, customer_address = ?
            WHERE customer_id = ?";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        // Correct order and types: s = string, s = string, i = integer, s = string, i = integer
        $stmt->bind_param("ssssi", $customer_nic, $customer_name, $customer_mobile, $customer_address, $customer_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows > 0;
    }

    public function delete($customer_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("UPDATE `customer` SET customer_status = '-1' WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
