<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Permission
{
    public function getAllRoles()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM role";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getAllModules()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM module WHERE module_status = 1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getAccessibleFunctionsWithModule($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "
        SELECT f.function_url, f.function_id, f.module_id
        FROM function f
        JOIN role_function rf ON f.function_id = rf.function_id
        JOIN role_module rm ON f.module_id = rm.module_id AND rf.role_id = rm.role_id
        JOIN user u ON u.user_role = rf.role_id
        WHERE u.user_id = '$user_id'
          AND f.function_status = 1
    ";

        $result = $con->query($sql) or die($con->error);
        $functions = [];

        while ($row = $result->fetch_assoc()) {
            $functions[] = $row;
        }

        return $functions;
    }

    public function getFunctionsByModule($module_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM function WHERE module_id = '$module_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getUserFunctions($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT function_id FROM function_user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);

        $functions = [];
        while ($row = $result->fetch_assoc()) {
            $functions[] = $row['function_id'];
        }
        return $functions;
    }

    public function getFunctionsByRole($role_id)
    {
        $con = $GLOBALS["con"];
        $sql = "
        SELECT f.function_id 
        FROM role_function rf 
        JOIN function f ON rf.function_id = f.function_id 
        WHERE rf.role_id = '$role_id'
    ";
        $result = $con->query($sql) or die($con->error);
        $functions = [];
        while ($row = $result->fetch_assoc()) {
            $functions[] = $row['function_id'];
        }
        return $functions;
    }


    public function addRoleFunction($role_id, $function_id)
    {
        $con = $GLOBALS["con"];
        $sql = "INSERT INTO role_function (role_id, function_id) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $role_id, $function_id);
        $stmt->execute();
        $stmt->close();
    }

    public function removeRoleFunction($role_id, $function_id)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM role_function WHERE role_id = ? AND function_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $role_id, $function_id);
        $stmt->execute();
        $stmt->close();
    }


    public function getUser($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT u.user_id, u.user_fname, u.user_lname, u.user_email, u.user_dob, u.user_nic, u.user_image, u.user_role, u.user_status, u.user_contact, r.role_name 
            FROM user u
            INNER JOIN role r ON u.user_role = r.role_id 
            WHERE u.user_id = '$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    // Insert module to role_module table (if not already exists)
    public function addRoleModule($role_id, $module_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM role_module WHERE role_id = ? AND module_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $role_id, $module_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmtInsert = $con->prepare("INSERT INTO role_module (role_id, module_id) VALUES (?, ?)");
            $stmtInsert->bind_param("ii", $role_id, $module_id);
            $stmtInsert->execute();
            $stmtInsert->close();
        }

        $stmt->close();
    }

    // Delete module from role_module table
    public function removeRoleModule($role_id, $module_id)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM role_module WHERE role_id = ? AND module_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $role_id, $module_id);
        $stmt->execute();
        $stmt->close();
    }

    public function getModuleIdByFunctionId($function_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT module_id FROM function WHERE function_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $function_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? $row['module_id'] : null;
    }

    public function deleteRole($role_id)
{
    $con = $GLOBALS["con"];

    // Optional: Delete related records first if there are foreign keys
    $con->query("DELETE FROM role_function WHERE role_id = '$role_id'");
    $con->query("DELETE FROM role_module WHERE role_id = '$role_id'");

    $stmt = $con->prepare("DELETE FROM role WHERE role_id = ?");
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $stmt->close();
}

public function deleteRoom($room_id)
{
    $con = $GLOBALS["con"];

    // Optional: Delete related records first if there are foreign keys
    $con->query("DELETE FROM room_function WHERE room_id = '$room_id'");
    $con->query("DELETE FROM room_module WHERE room_id = '$room_id'");

    $stmt = $con->prepare("DELETE FROM room WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $stmt->close();
}
}
