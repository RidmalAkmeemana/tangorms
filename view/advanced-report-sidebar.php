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

        <?php if (in_array('reports.php', $accessibleUrls)) { ?>
            <a href="reports.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('sales-report.php', $accessibleUrls)) { ?>
            <a href="sales-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Sales Report
            </a>
        <?php } ?>

        <?php if (in_array('customer-outstanding-report.php', $accessibleUrls)) { ?>
            <a href="customer-outstanding-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Customer Outstanding Report
            </a>
        <?php } ?>

        <?php if (in_array('payment-report.php', $accessibleUrls)) { ?>
            <a href="payment-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Payment Report
            </a>
        <?php } ?>
    </ul>
</div>