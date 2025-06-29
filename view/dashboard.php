<?php 
include_once '../commons/session.php';
include_once '../model/module_model.php';

// Get user information from session
$userrow = $_SESSION["user"];

$moduleObj = new Module();
// Get only the modules that the current user has access to
$moduleResult = $moduleObj->getModulesByUser($userrow["user_id"]);
?>

<html lang="en">
<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
    <link rel="stylesheet" href="../css/dashboard.css"> 
</head>
<body>
    <div class="container">
        <?php $pageName = "DASHBOARD"; ?>
        <?php include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php while ($module_row = $moduleResult->fetch_assoc()): ?> 
                <div class="col-md-4 mb-4">
                    <a href="<?= htmlspecialchars($module_row["module_url"]) ?>" style="text-decoration: none; color: #fff">
                        <div class="panel">
                            <h1 align="center">
                                <img src="../images/icons/<?= htmlspecialchars($module_row["module_icon"]) ?>" height="100px" width="80px"/>
                            </h1>
                            <h4 align="center">
                                <?= htmlspecialchars($module_row["module_name"]) ?>
                            </h4>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- JavaScript Includes -->
    <script src="../js/jquery-3.7.1.js"></script>
</body>
</html>