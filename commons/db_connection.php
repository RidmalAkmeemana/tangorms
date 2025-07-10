<?php
class DbConnection{

    private $hostname="localhost";
    private $dbname="tango_restaurant_management_db";
    private $dbusername="root";
    private $dbpassword="";
    public $con;

    public function __construct(){

        $this->con = new mysqli($this->hostname,
                                $this->dbusername,
                                $this->dbpassword,
                                $this->dbname);

        if(!$this->con->connect_error){
            
            $GLOBALS["con"]=$this->con;

        }

    }

}

date_default_timezone_set("Asia/Colombo");

?>

