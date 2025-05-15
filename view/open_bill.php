<?php
include_once '../commons/session.php';
include_once '../model/table-model.php';
include_once '../model/pos_model.php';  

$tableObj = new RestaurantTable();
$posObj = new Pos(); //  Create this class later

if (!isset($_GET['table_id'])) {
    //  Handle error - no table ID provided
    echo "Error: No table selected.";
    exit;
}

$table_id = $_GET['table_id'];
$table = $tableObj->getTable($table_id)->fetch_assoc();

//  Get the current user's ID (waiter) from the session
$waiter_id = $_SESSION['user']['user_id'];  //  Assuming you store user_id in session

//  Open the bill and get the new order ID
$order_id = $posObj->openBill($table_id, $waiter_id);

if ($order_id) {
    //  Update table status to "Occupied" (status_id = 6)
    $tableObj->updateTableStatus($table_id, 6);

    //  Redirect to the add_items page to start adding items to the bill
    header("Location: add_items.php?order_id=$order_id&table_id=$table_id");
    exit;
} else {
    //  Handle error - bill not opened
    echo "Error: Could not open bill.";
    exit;
}
?>