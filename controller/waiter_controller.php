<?php
include '../commons/session.php';
include_once '../model/waiter_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
    echo "<script>window.location = '../view/login.php';</script>";
    exit();
}

$status = $_GET["status"];
$waiterObj = new Waiter();

switch ($status) {

    case "update_order":
        try {
            $receipt_no = $_POST['receipt_no'];
            $order_status = $_POST['order_status'];
            $reason = $_POST['reason'] ?? null;
            $payment_status = $_POST['payment_status'];
            $table_id = $_POST['table_id'] ?? null;

            if (empty($receipt_no) || empty($order_status) || empty($payment_status)) {
                throw new Exception("Missing required fields.");
            }

            // If the status is 'Rejected' and payment is not 'Unpaid', show alert
            if ($order_status === "Rejected" && $payment_status !== "Unpaid") {
                echo "<script>
                    alert('Please reverse the payment before canceling or rejecting the order.');
                    window.location = '../view/view-waiter-orders.php';
                </script>";
                exit();
            }

            // Determine if reason needs to be updated
            if ($order_status === "Rejected") {
                if (empty($reason)) {
                    throw new Exception("Reason is required for Rejected or Canceled status.");
                }
                $waiterObj->updateOrderStatus($receipt_no, $order_status, $reason);
            } else {
                $waiterObj->updateOrderStatus($receipt_no, $order_status, null);
            }

            // After updating the order, fetch the updated data
            $orderData = $waiterObj->getOrderByReceiptNo($receipt_no);

            // If the order is Completed and it's a Dine-In, mark table as Dirty
            if (
                $order_status === "Completed" &&
                isset($orderData["order_type"], $orderData["table_id"]) &&
                $orderData["order_type"] === "Dine-In" &&
                !empty($orderData["table_id"])
            ) {
                $waiterObj->updateTableStatus($orderData["table_id"], "Dirty");
            }

            $msg = base64_encode("Order status updated successfully.");
            echo "<script>window.location = '../view/view-waiter-orders.php?msg=$msg';</script>";
            exit();

        } catch (Exception $ex) {
            $msg = base64_encode("Error: " . $ex->getMessage());
            echo "<script>window.location = '../view/view-waiter-orders.php?msg=$msg';</script>";
            exit();
        }

        break;

    default:
        echo "<script>window.location = '../view/login.php';</script>";
        exit();
}
