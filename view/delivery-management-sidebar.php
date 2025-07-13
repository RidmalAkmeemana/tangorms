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

        <?php if (in_array('delivery.php', $accessibleUrls)) { ?>
            <a href="delivery.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('view-delivery-orders.php', $accessibleUrls)) { ?>
            <a href="view-delivery-orders.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View Orders
            </a>
        <?php } ?>

        <?php if (in_array('delivery-report.php', $accessibleUrls)) { ?>
            <a href="delivery-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Delivery Report
            </a>
        <?php } ?>
    </ul>
</div>