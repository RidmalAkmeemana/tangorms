<?php
include_once '../model/user_model.php';

$userrow = $_SESSION['user'];
$user_id = $userrow['user_id'];
$userObj = new User();

// Get all accessible function URLs (that match role + module permissions)
$accessibleFunctions = $userObj->getAccessibleFunctionsWithModule($user_id);
$accessibleUrls = array_column($accessibleFunctions, 'function_url');
?>
<div class="col-md-3">
    <ul class="list-group">
        <!-- Home link is always visible -->
        <a href="dashboard.php" class="list-group-item">
            <span class="glyphicon glyphicon-home"></span> &nbsp; Home
        </a>
        <!-- Permission-based links -->

        <?php if (in_array('user.php', $accessibleUrls)) { ?>
            <a href="user.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('add-user.php', $accessibleUrls)) { ?>
            <a href="add-user.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add User
            </a>
        <?php } ?>

        <?php if (in_array('view-users.php', $accessibleUrls)) { ?>
            <a href="view-users.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Users
            </a>
        <?php } ?>

         <!-- Home link is always visible -->
        <a href="user-report.php" class="list-group-item" target="_blank">
            <span class="glyphicon glyphicon-book"></span> &nbsp; Generate User Report
        </a>
    </ul>
</div>