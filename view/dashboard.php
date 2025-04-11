<?php 
include_once '../commons/session.php';
include_once '../model/module_model.php';

// Get user information from session
$userrow = $_SESSION["user"];

$moduleObj = new Module();
$moduleResult = $moduleObj->getAllModules();
?>

<html lang="en">
<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
    <style>
        /* Custom Theme Colors */
        body {
            background-color: black; /* Black background */
            color: white; /* White text */
        }

        .panel {
            background-color: #333; /* Dark background for panels */
            border: 1px solid #FF6600; /* Orange border for panels */
        }

        .panel h1, .panel h4 {
            color: white; /* White text for titles inside panels */
        }

        .panel:hover {
            background-color: #444; /* Slightly darker panel on hover */
        }

        a {
            text-decoration: none; /* Remove underline from links */
            color: inherit; /* Inherit the color from parent */
        }

        .panel-heading {
            background-color: #FF6600; /* Orange background for panel heading */
            color: white;
        }

        h1 {
            color: #FF6600; /* Orange color for headings */
        }

        .col-md-4 {
            margin-bottom: 20px;  Add margin at the bottom of each module panel 
        }

        .logo-container img {
            max-width: 100%;
            height: auto;
            max-height: 250px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php $pageName="DASHBOARD" ?>
        <?php include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php
                while ($module_row = $moduleResult->fetch_assoc()) {
            ?> 
                <div class="col-md-4">
                    <a href="<?php echo $module_row["module_url"] ?>" style="text-decoration:none;color:#fff">
                        <div class="panel">
                            <h1 align="center">
                                <img src="../images/icons/<?php echo $module_row["module_icon"] ?>" height="100px" width="80px"/>
                            </h1>
                            <h4 align="center">
                                <?php echo $module_row["module_name"]; ?>
                            </h4>
                        </div>
                    </a>
                </div>
            <?php
                }
            ?>    
        </div>
        
    </div>

    <!-- JavaScript Includes -->
    <script src="../js/jquery-3.7.1.js"></script>
</body>
</html>
