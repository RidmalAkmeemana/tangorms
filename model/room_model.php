<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Room
{
    public function addRoom($room_name, $file_name)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("
            INSERT INTO `room` (room_name, room_layout, room_status)
            VALUES (?, ?, 1)
        ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("ss", $room_name, $file_name);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $room_id = $stmt->insert_id;
        $stmt->close();

        return $room_id;
    }

    public function getRoom($room_id)
    {
        $con = $GLOBALS["con"];

        $stmt = $con->prepare("
        SELECT 
            r.room_id, 
            r.room_name, 
            r.room_layout, 
            r.room_status,
            t.table_name,
            t.table_status
        FROM room AS r
        LEFT JOIN `table` AS t ON r.room_id = t.room_id
        WHERE r.room_id = ?
    ");

        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }



    public function UpdateRoom($room_id, $room_name, $file_name)
{
    $con = $GLOBALS["con"];
    $sql = "UPDATE `room` 
            SET room_name = ?, room_layout = ?
            WHERE room_id = ?";

    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    // Corrected: s = string, s = string, i = integer
    $stmt->bind_param("ssi", $room_name, $file_name, $room_id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    return $stmt->affected_rows > 0;
}



    public function getAllRooms()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM room WHERE room_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function activateRoom($room_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE room SET room_status='1' WHERE room_id ='$room_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deactivateRoom($room_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE room SET room_status='0' WHERE room_id ='$room_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deleteRoom($room_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("UPDATE `room` SET room_status = '-1' WHERE room_id = ?");
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
