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

        <?php if (in_array('pos.php', $accessibleUrls)) { ?>
            <a href="pos.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('add-customer.php', $accessibleUrls)) { ?>
            <a href="add-customer.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Customer
            </a>
        <?php } ?>

        <?php if (in_array('view-customers.php', $accessibleUrls)) { ?>
            <a href="view-customers.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Customer
            </a>
        <?php } ?>

        <?php if (in_array('pos-sale.php', $accessibleUrls)) { ?>
            <a href="pos-sale.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; POS Sale
            </a>
        <?php } ?>

        <?php if (in_array('customer-report.php', $accessibleUrls)) { ?>
            <a href="customer-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Customer Report
            </a>
        <?php } ?>
    </ul>
</div>