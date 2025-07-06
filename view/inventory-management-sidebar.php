<?php
include_once '../model/inventory_model.php';

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

        <?php if (in_array('inventory.php', $accessibleUrls)) { ?>
            <a href="inventory.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('view-inventories.php', $accessibleUrls)) { ?>
            <a href="view-inventories.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Inventories
            </a>
        <?php } ?>

        <?php if (in_array('inventory-report.php', $accessibleUrls)) { ?>
            <a href="inventory-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Inventory Report
            </a>
        <?php } ?>
    </ul>
</div>