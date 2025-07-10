<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Table
{
    public function addTable($table_name, $seat_count, $table_status, $room_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("
            INSERT INTO `table` (table_name, seat_count, table_status, room_id)
            VALUES (?, ?, ?, ?)
        ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

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
        $stmt = $con->prepare("SELECT table_id, seat_count, table_name, table_status, room_id FROM `table` WHERE table_id = ?");
        $stmt->bind_param("i", $table_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function updateTable($table_id, $table_name, $seat_count, $table_status, $room_id)
{
    $con = $GLOBALS["con"];
    $sql = "UPDATE `table` 
            SET table_name = ?, seat_count = ?, table_status = ?, room_id = ?
            WHERE table_id = ?";

    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    // s = string, s = string, i = integer, i = integer
    $stmt->bind_param("sisii", $table_name, $seat_count, $table_status, $room_id, $table_id);

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

    $sql = "SELECT t.*, r.room_name 
            FROM `table` t
            INNER JOIN `room` r ON t.room_id = r.room_id";

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
                FROM `table`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function deleteTable($table_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("UPDATE `table` SET table_status = 'Out of Service' WHERE table_id = ?");
        $stmt->bind_param("i", $table_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
