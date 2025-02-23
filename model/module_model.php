<?php

include '../commons/db_connection.php';

$dbcon = new DbConnection();

class Module{

    function getAllModules(){
        $conn=$GLOBALS["con"];
        $sql="SELECT * FROM module";
        $result = $conn->query($sql) or die($conn->error);
        return $result;
    }
}
