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

        <?php if (in_array('reservation.php', $accessibleUrls)) { ?>
            <a href="reservation.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('add-reservation.php', $accessibleUrls)) { ?>
            <a href="add-reservation.php" class="list-group-item">
                <span class="glyphicon glyphicon-plus"></span> &nbsp; Add Reservation
            </a>
        <?php } ?>

        <?php if (in_array('view-reservations.php', $accessibleUrls)) { ?>
            <a href="view-reservations.php" class="list-group-item">
                <span class="glyphicon glyphicon-search"></span> &nbsp; View Reservation
            </a>
        <?php } ?>

        <?php if (in_array('reservation-report.php', $accessibleUrls)) { ?>
            <a href="reservation-report.php" class="list-group-item">
                <span class="glyphicon glyphicon-book"></span> &nbsp; Generate Reservation Report
            </a>
        <?php } ?>
    </ul>
</div>