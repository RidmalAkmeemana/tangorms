<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Module
{
    // Get all modules (regardless of user access)
    public function getAllModules()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM module WHERE module_status = 1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    // Get modules accessible by a specific user via their role
    public function getModulesByUser($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "
        SELECT DISTINCT m.module_id, m.module_name, m.module_url, m.module_icon
        FROM user u
        JOIN role_module rm ON u.user_role = rm.role_id
        JOIN module m ON rm.module_id = m.module_id
        WHERE u.user_id = '$user_id'
          AND m.module_status = 1
    ";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}
