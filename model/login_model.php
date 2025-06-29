<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Login{

public function validateUser($login_username, $login_password) {
        $con = $GLOBALS["con"];

        // Use MD5 if that's what's stored in DB
        $login_password = md5($login_password); 

        // Secure query with prepared statements
        $stmt = $con->prepare("SELECT * FROM user WHERE user_email = ? AND user_password = ? AND user_status = 1");
        $stmt->bind_param("ss", $login_username, $login_password);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result;
    }

public function addUserLogin($user_id,$user_email,$nic){  

    $con = $GLOBALS["con"];
    $pw = sha1($nic);
    $sql = "INSERT INTO login (login_username,login_password,user_id) values ('$user_email','$pw','$user_id')";

    $result = $con->query($sql) or die($con->error);
     return $result;
    }
    
}

