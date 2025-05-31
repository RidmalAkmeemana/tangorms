<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class RestaurantTable
{

    public function addtables($table_name, $capacity, $status, $room_id)
    {

        $con = $GLOBALS["con"];
        $sql = "INSERT INTO restaurant_table (table_name,capacity,status_id,room_id) VALUES ('$table_name','$capacity','$status','$room_id')";
        $con->query($sql) or die($con->error);
    }

    public function gettables()
    {

        $con = $GLOBALS["con"];
        $sql = "SELECT restaurant_table.*, room.room_name, room_status.status_name 
                FROM restaurant_table 
                JOIN room ON restaurant_table.room_id = room.room_id
                JOIN room_status ON restaurant_table.status_id = room_status.status_id";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    public function getTable($table_id) {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM restaurant_table WHERE table_id = '$table_id'"; 
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function updateRoomLayout($room_id, $room_layout)
    {
        $con = $GLOBALS["con"];
        $sql_update = "UPDATE room SET room_layout = '$room_layout' WHERE room_id ='$room_id'";
        $stmt_update = $con->prepare($sql_update);
    }
    
     public function addRoom($room_name, $room_layout)
    {
        $con = $GLOBALS["con"];
        $sql = "INSERT INTO room (room_name,room_layout) VALUES ('$room_name','$room_layout')";
      
        $con->query($sql) or die($con->error);
    }
    
    public function updateTableStatus($table_id, $status_id) {  //  Change to status_id
        $con = $GLOBALS["con"];
        $sql = "UPDATE restaurant_table SET status_id = '$status_id' WHERE table_id = '$table_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getAllRooms()
    {

        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM room";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function getRoom($room_id)
    {

        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM room WHERE room_id='$room_id'";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }
        public function getTableStatus($status_id)
    {

        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM room_status WHERE status_id='$status_id'";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getAllStatus()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM room_status";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function updateTable($table_id,$table_name, $room_id, $capacity, $status){
        
        $con=$GLOBALS["con"];
        $sql = "UPDATE restaurant_table SET table_name ='$table_name', capacity ='$capacity', room_id='$room_id',status_id='$status' WHERE table_id='$table_id'";
        $result = $con->query($sql) or die($con->error);
       
    }
    
    public function deleteTable($table_id){
        $con=$GLOBALS["con"];
        $sql = "UPDATE restaurant_table SET status_id='0' WHERE table_id ='$table_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function getVacantTables(){
        $con=$GLOBALS["con"];
        $sql = "SELECT COUNT(table_id) as vacant_count FROM restaurant_table WHERE status_id = '1'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function getReservedTables(){
        $con=$GLOBALS["con"];
        $sql = "SELECT COUNT(table_id) as Reserved_count FROM restaurant_table WHERE status_id = '2'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
     public function getSeatedTables(){
        $con=$GLOBALS["con"];
        $sql = "SELECT COUNT(table_id) as Seated_count FROM restaurant_table WHERE status_id = '3'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
      public function getDirtyTables(){
        $con=$GLOBALS["con"];
        $sql = "SELECT COUNT(table_id) as Dirty_count FROM restaurant_table WHERE status_id = '4'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
      public function getOOSTables(){
        $con=$GLOBALS["con"];
        $sql = "SELECT COUNT(table_id) as OOS_count FROM restaurant_table WHERE status_id = '5'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    
}