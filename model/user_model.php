<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class User{

    public function getAllRoles(){

        $con=$GLOBALS["con"];
        $sql = "SELECT * FROM role";

        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
       public function getRoleModules($roleId){
        
        $con=$GLOBALS["con"];
        $sql = "SELECT * FROM role_module r, module m WHERE r.module_id = m.module_id AND r.role_id='$roleId'";
        $result = $con->query($sql) or die($con->error);
        return $result;
        
    }
    
      public function getModuleFunctions($moduleId){  
        
        $con=$GLOBALS["con"];
        $sql = "SELECT * FROM function WHERE module_id='$moduleId'";
        $result = $con->query($sql) or die($con->error);
        return $result;
        
    }
    
    public function addUser($fname,$lname,$email,$dob,$nic,$user_role,$user_image) {
        $con=$GLOBALS["con"];
        $sql = "INSERT INTO user (user_fname,user_lname,user_email,user_dob,user_nic,user_role,user_image) VALUES ('$fname','$lname','$email','$dob','$nic','$user_role','$user_image')";        $result = $con->query($sql) or die($con->error);
        $user_id=$con->insert_id;
        return $user_id; 
    }
    
    public function addUserFunctions($user_id,$fun_id){
        
        $con=$GLOBALS["con"];
        $sql="INSERT INTO function_user (function_id,user_id) VALUES ('$fun_id','$user_id')";
        $con->query($sql) or die($con->error);
        
    }
    
     public function addUserContact($user_id,$contact_no){
        
        $con=$GLOBALS["con"];
        $sql="INSERT INTO user_contact (contact_number,user_id) VALUES ('$contact_no','$user_id')";
        $con->query($sql) or die($con->error);
        
    }
    
        public function getUserContact($user_id){
        
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM user_contact WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
        
    }
    
    public function getAllUsers(){
        
        $con=$GLOBALS["con"];
        $sql = "SELECT * FROM User WHERE user_status!='-1'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function activateUser($user_id){
        
        $con=$GLOBALS["con"];
        $sql = "UPDATE user SET user_status='1' WHERE user_id ='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
     public function deactivateUser($user_id){
        
        $con=$GLOBALS["con"];
        $sql = "UPDATE user SET user_status='0' WHERE user_id ='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function deleteUser ($user_id){
        $con=$GLOBALS["con"];
        $sql = "UPDATE user SET user_status='-1' WHERE user_id ='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function getUser($user_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM user u , role r WHERE u.user_role = r.role_id AND user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function getUserFunctions($user_id){
        $con=$GLOBALS["con"];
        $sql = "SELECT * FROM function_user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
    
    public function UpdateUser($fname,$lname,$email,$dob,$nic,$user_role,$user_image,$user_id){
        
        $con=$GLOBALS["con"];
        $sql = "UPDATE user SET user_fname='$fname', user_lname='$lname', user_email='$email', "
                . "user_dob='$dob', user_nic='$nic', user_image='$user_image', user_role='$user_role' WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        
    }
            
     public function removeUserContact($user_id){
        
        $con=$GLOBALS["con"];
        $sql="DELETE FROM user_contact WHERE user_id='$user_id'";
        $result=$con->query($sql) or die($con->error);
    
    }
    
    public function removeUserFunctions($user_id){
        
        $con=$GLOBALS["con"];
        $sql="DELETE FROM function_user WHERE user_id='$user_id'";
        $result=$con->query($sql) or die($con->error);
        
    }
    
 }