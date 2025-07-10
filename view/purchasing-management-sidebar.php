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

        <?php if (in_array('purchasing.php', $accessibleUrls)) { ?>
            <a href="purchasing.php" class="list-group-item">
                <span class="glyphicon glyphicon-th-list"></span> &nbsp; Main Menu
            </a>
        <?php } ?>

        <?php if (in_array('receipt-payment.php', $accessibleUrls)) { ?>
            <a href="receipt-payment.php" class="list-group-item">
                <span class="glyphicon glyphicon-usd"></span> &nbsp; Receipt Payment
            </a>
        <?php } ?>

        <?php if (in_array('payment-reversal.php', $accessibleUrls)) { ?>
            <a href="payment-reversal.php" class="list-group-item">
                <span class="glyphicon glyphicon-retweet"></span> &nbsp; Payment Reversal
            </a>
        <?php } ?>
    </ul>
</div>