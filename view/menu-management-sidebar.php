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

        <?php if (in_array('menu.php', $accessibleUrls)) { ?>
            <a href="menu.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('add-category.php', $accessibleUrls)) { ?>
            <a href="add-category.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Category
            </a>
        <?php } ?>

        <?php if (in_array('view-categories.php', $accessibleUrls)) { ?>
            <a href="view-categories.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Categories
            </a>
        <?php } ?>

        <?php if (in_array('add-item.php', $accessibleUrls)) { ?>
            <a href="add-item.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Item
            </a>
        <?php } ?>

        <?php if (in_array('view-items.php', $accessibleUrls)) { ?>
            <a href="view-items.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View All Items
            </a>
        <?php } ?>

        <?php if (in_array('category-report.php', $accessibleUrls)) { ?>
            <a href="category-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Category Report
            </a>
        <?php } ?>

        <?php if (in_array('item-report.php', $accessibleUrls)) { ?>
            <a href="item-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Item Report
            </a>
        <?php } ?>
    </ul>
</div>