<?php

include_once '../commons/session.php';
include_once '../model/module_model.php';

//get user information from session
$userrow=$_SESSION["user"];

$moduleObj = new Module();

$moduleResult = $moduleObj->getAllModules();


?>

<html>
    <head>
        <?php include_once "../includes/bootstrap_css_includes.php"?>
    </head>
    <body>
        
    </body>
    
</html>