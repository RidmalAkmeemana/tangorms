<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Reservation
{
    public function getReservationStatusCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN reservation_status = 'Reserved' THEN 1 END) AS reserved_count
                FROM `reservations`";

        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getReservationTableCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN table_status = 'Reserved' THEN 1 END) AS reserved_table_count
                FROM `table`";

        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getReservationNo()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT `value` FROM `temp_reservation` LIMIT 1"; // narrow query to just what you need
        $result = $con->query($sql) or die($con->error);

        if ($row = $result->fetch_assoc()) {
            // Replace 'value' with actual column name if different
            $rawValue = isset($row['value']) ? $row['value'] : 1;
            return 'TANGORES' . str_pad($rawValue, 5, '0', STR_PAD_LEFT);
        } else {
            return 'TANGORES00001';
        }
    }

    public function getTables()
    {
        $con = $GLOBALS["con"];

        $sql = "SELECT * FROM `table`
                WHERE table_status IN ('Vacant', 'Reserved')";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function isTableReserved($table_id, $reserved_date)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT COUNT(*) AS count FROM reservations 
            WHERE table_id = ? 
              AND DATE(reserved_date) = DATE(?) 
              AND reservation_status = 'Reserved'";

        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }
        $stmt->bind_param("is", $table_id, $reserved_date);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['count'] > 0;
    }

    public function markTableAsReserved($table_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `table` SET table_status = 'Reserved' WHERE table_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $table_id);
        return $stmt->execute();
    }

    public function markTableAsVacant($table_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `table` SET table_status = 'Vacant' WHERE table_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $table_id);
        return $stmt->execute();
    }

    public function addReservation($reservation_no, $customer_id, $table_id, $reserved_date)
    {
        $con = $GLOBALS["con"];

        // Set default values
        $reservation_status = "Reserved";

        // Prepare statement
        $stmt = $con->prepare("
        INSERT INTO `reservations` (
            reservation_no, 
            customer_id, 
            reservation_status, 
            table_id, 
            reserved_date
        ) VALUES (?, ?, ?, ?, ?)
    ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param(
            "sisis",
            $reservation_no,
            $customer_id,
            $reservation_status,
            $table_id,
            $reserved_date
        );

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $inserted_id = $stmt->insert_id;
        $stmt->close();

        return $inserted_id;
    }

    // Update Reservation Number
    public function updateReservationNo()
    {
        $con = $GLOBALS["con"];
        return $con->query("UPDATE temp_reservation SET value = value + 1");
    }

    public function getAllReservations()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                r.*, 
                c.customer_name, 
                t.table_name 
            FROM 
                reservations r
            LEFT JOIN 
                customer c ON r.customer_id = c.customer_id
            LEFT JOIN 
                `table` t ON r.table_id = t.table_id";

        $result = $con->query($sql);

        if (!$result) {
            die("Query failed: " . $con->error);
        }

        return $result;
    }

    public function getReservationByReservationNo($reservation_no)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    r.*, 
                    c.customer_name, 
                    t.table_name 
                FROM 
                    reservations r
                LEFT JOIN 
                    customer c ON r.customer_id = c.customer_id
                LEFT JOIN 
                    `table` t ON r.table_id = t.table_id
                WHERE 
                    r.reservation_no = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $reservation_no);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function editReservation($reservation_no, $table_id, $reserved_date, $reservation_status)
    {
        $con = $GLOBALS["con"];

        // Update reservation table by reservation_no
        $stmt = $con->prepare("
        UPDATE `reservations`
        SET table_id = ?, 
            reserved_date = ?, 
            reservation_status = ?
        WHERE reservation_no = ?
    ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("isss", $table_id, $reserved_date, $reservation_status, $reservation_no);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        return $affectedRows;
    }

    public function hasOtherActiveReservations($table_id, $exclude_reservation_no)
{
    $con = $GLOBALS["con"];
    $sql = "SELECT COUNT(*) AS count FROM reservations 
            WHERE table_id = ? AND reservation_status != 'Canceled' AND reservation_no != ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("is", $table_id, $exclude_reservation_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] > 0;
}
}
