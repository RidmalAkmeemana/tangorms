<?php
include_once '../model/role_model.php';

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

        <?php if (in_array('role.php', $accessibleUrls)) { ?>
            <a href="role.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('add-role.php', $accessibleUrls)) { ?>
            <a href="add-role.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Role
            </a>
        <?php } ?>

        <?php if (in_array('view-roles.php', $accessibleUrls)) { ?>
            <a href="view-roles.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Roles
            </a>
        <?php } ?>

         <!-- Home link is always visible -->

         <a href="screen-permission.php" class="list-group-item">
                <span class="glyphicon glyphicon-user"></span> &nbsp; Screen Permission
            </a>

        <a href="role-report.php" class="list-group-item" target="_blank">
            <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Role Report
        </a>
    </ul>
</div>