<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class User
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
    
    public function getFunctionsByRole($role_id) {
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

public function addUser($fname, $lname, $email, $password, $dob, $nic, $user_role, $user_image, $contact) {
    $con = $GLOBALS["con"];

    // Validate and format DOB to 'YYYY-MM-DD'
    $dobFormatted = date('Y-m-d', strtotime($dob)); // Converts any valid date string to proper format

    // Hash the password
    $hashedPassword = md5($password); // Consider using password_hash() for better security

    // Use prepared statement to avoid SQL injection
    $stmt = $con->prepare("
        INSERT INTO user (
            user_fname, user_lname, user_email, user_password,
            user_dob, user_nic, user_image, user_role, user_status, user_contact
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param(
        "sssssssis",
        $fname,
        $lname,
        $email,
        $hashedPassword,
        $dobFormatted,
        $nic,
        $user_image,
        $user_role,
        $contact
    );

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $user_id = $stmt->insert_id;
    $stmt->close();

    return $user_id;
}


    public function addUserFunctions($user_id, $fun_id)
    {
        $con = $GLOBALS["con"];
        $sql = "INSERT INTO function_user (function_id,user_id) VALUES ('$fun_id','$user_id')";
        $con->query($sql) or die($con->error);
    }

    public function removeUserFunctions($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM function_user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
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

    public function UpdateUser($user_id, $fname, $lname, $email, $password, $dob, $nic, $user_role, $user_image, $contact)
    {
        $con = $GLOBALS["con"];
        $dobFormatted = date('Y-m-d', strtotime($dob));

        if (!empty($password)) {
            $hashedPassword = md5($password);
            $sql = "UPDATE user SET 
                        user_fname = ?, 
                        user_lname = ?, 
                        user_email = ?, 
                        user_dob = ?, 
                        user_nic = ?, 
                        user_image = ?, 
                        user_role = ?, 
                        user_contact = ?, 
                        user_password = ?
                    WHERE user_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param(
                "ssssssissi",
                $fname,
                $lname,
                $email,
                $dobFormatted,
                $nic,
                $user_image,
                $user_role,
                $contact,
                $hashedPassword,
                $user_id
            );
        } else {
            $sql = "UPDATE user SET 
                        user_fname = ?, 
                        user_lname = ?, 
                        user_email = ?, 
                        user_dob = ?, 
                        user_nic = ?, 
                        user_image = ?, 
                        user_role = ?, 
                        user_contact = ?
                    WHERE user_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param(
                "ssssssisi",
                $fname,
                $lname,
                $email,
                $dobFormatted,
                $nic,
                $user_image,
                $user_role,
                $contact,
                $user_id
            );
        }

        $result = $stmt->execute();

        if (!$result) {
            die("Update failed: " . $stmt->error);
        }

        return $result;
    }

    public function getAllUsers()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM user WHERE user_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getUserStatusCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    SUM(user_status = 1) AS active_count,
                    SUM(user_status = 0) AS inactive_count
                FROM user";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function activateUser($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE user SET user_status='1' WHERE user_id ='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deactivateUser($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE user SET user_status='0' WHERE user_id ='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deleteUser($user_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE user SET user_status='-1' WHERE user_id ='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}