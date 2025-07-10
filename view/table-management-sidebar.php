<?php
include_once '../model/table_model.php';

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

        <?php if (in_array('table.php', $accessibleUrls)) { ?>
            <a href="table.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('add-room.php', $accessibleUrls)) { ?>
            <a href="add-room.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Room
            </a>
        <?php } ?>

        <?php if (in_array('view-rooms.php', $accessibleUrls)) { ?>
            <a href="view-rooms.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Rooms
            </a>
        <?php } ?>

        <?php if (in_array('add-table.php', $accessibleUrls)) { ?>
            <a href="add-table.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Table
            </a>
        <?php } ?>

        <?php if (in_array('view-tables.php', $accessibleUrls)) { ?>
            <a href="view-tables.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Tables
            </a>
        <?php } ?>

        <?php if (in_array('room-report.php', $accessibleUrls)) { ?>
            <a href="room-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Room Report
            </a>
        <?php } ?>

        <?php if (in_array('table-report.php', $accessibleUrls)) { ?>
            <a href="table-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Table Report
            </a>
        <?php } ?>
    </ul>
</div>