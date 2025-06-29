<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Table
{
    public function addTable($table_name, $seat_count, $table_status, $room_id)
{
    $con = $GLOBALS["con"];

    // Use backticks around `table` to avoid conflict with reserved keyword
    $stmt = $con->prepare("
        INSERT INTO `table` (table_name, seat_count, table_status, room_id)
        VALUES (?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    // s = string, i = integer
    $stmt->bind_param("sisi", $table_name, $seat_count, $table_status, $room_id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $table_id = $stmt->insert_id;
    $stmt->close();

    return $table_id;
}

    public function getTable($table_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT table_id, table_name 
            FROM table
            WHERE table_id = '$table_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function UpdateTable($table_id, $table_name, $seat_count, $table_status)
    {
        $con = $GLOBALS["con"];

        // Corrected table name using backticks since 'table' is a reserved keyword in SQL
        $sql = "UPDATE `table` 
            SET table_name = ?, seat_count = ?, table_status = ?
            WHERE table_id = ?";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        // Corrected parameter order and types: s = string, i = integer
        $stmt->bind_param("sisi", $table_name, $seat_count, $table_status, $table_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows > 0;
    }


    public function getAllRooms()
    {

        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM room";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }


    public function getAllTables()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM table WHERE table_status != 'Out of Service'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getTableStatusCounts()
    {
        $con = $GLOBALS["con"];

        $sql = "SELECT 
                COUNT(CASE WHEN table_status = 'Vacant' THEN 1 END) AS vacant_count,
                COUNT(CASE WHEN table_status = 'Out of Service' THEN 1 END) AS out_of_service_count,
                COUNT(CASE WHEN table_status = 'Reserved' THEN 1 END) AS reserved_count,
                COUNT(CASE WHEN table_status = 'Seated' THEN 1 END) AS seated_count,
                COUNT(CASE WHEN table_status = 'Dirty' THEN 1 END) AS dirty_count
            FROM `table`";  // Enclose in backticks

        $result = $con->query($sql) or die($con->error);

        return $result->fetch_assoc();
    }

    public function deleteTable($table_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE table SET table_status='Out of Service' WHERE table_id ='$table_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}
