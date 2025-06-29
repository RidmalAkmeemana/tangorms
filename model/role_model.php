<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Role
{
    public function addRole($role_name)
    {
        $con = $GLOBALS["con"];

        // Prepare statement to insert new role
        $stmt = $con->prepare("
        INSERT INTO role (role_name, role_status)
        VALUES (?, 1)
    ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("s", $role_name);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $role_id = $stmt->insert_id;
        $stmt->close();

        return $role_id;
    }
    public function getRole($role_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT role_id, role_name 
            FROM role
            WHERE role_id = '$role_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function UpdateRole($role_id, $role_name)
    {
        $con = $GLOBALS["con"];

        $sql = "UPDATE role SET role_name = ? WHERE role_id = ?";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("si", $role_name, $role_id); // s = string, i = integer

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows > 0;
    }


    public function getAllRoles()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM role WHERE role_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getRoleStatusCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    SUM(role_status = 1) AS active_count,
                    SUM(role_status = 0) AS inactive_count
                FROM role";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function activateRole($role_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE role SET role_status='1' WHERE role_id ='$role_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deactivateRole($role_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE role SET role_status='0' WHERE role_id ='$role_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deleteRole($role_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE role SET role_status='-1' WHERE role_id ='$role_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}
