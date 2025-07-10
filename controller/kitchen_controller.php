<?php
include '../commons/session.php';
include_once '../model/kitchen_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
    echo "<script>window.location = '../view/login.php';</script>";
    exit();
}

$status = $_GET["status"];
$kitchenObj = new Kitchen();

switch ($status) {

    case "update_order":

        try {
            $receipt_no = $_POST['receipt_no'];
            $order_status = $_POST['order_status'];
            $reason = $_POST['reason'] ?? null;
            $payment_status = $_POST['payment_status'];
    
            if (empty($receipt_no) || empty($order_status) || empty($payment_status)) {
                throw new Exception("Missing required fields.");
            }
    
            // If the status is 'Rejected' or 'Canceled' and payment is not 'Unpaid', show alert
            if (
                ($order_status === "Rejected" || $order_status === "Canceled") &&
                $payment_status !== "Unpaid"
            ) {
                echo "<script>
                    alert('Please reverse the payment before canceling or rejecting the order.');
                    window.location = '../view/view-kitchen-orders.php';
                </script>";
                exit();
            }
    
            // Determine if reason needs to be updated
            if ($order_status === "Rejected" || $order_status === "Canceled") {
                if (empty($reason)) {
                    throw new Exception("Reason is required for Rejected or Canceled status.");
                }
                $kitchenObj->updateOrderStatus($receipt_no, $order_status, $reason);
            } else {
                $kitchenObj->updateOrderStatus($receipt_no, $order_status, null); // Pass null if no reason needed
            }
    
            $msg = base64_encode("Order status updated successfully.");
            echo "<script>window.location = '../view/view-kitchen-orders.php?msg=$msg';</script>";
            exit();
    
        } catch (Exception $ex) {
            $msg = base64_encode("Error: " . $ex->getMessage());
            echo "<script>window.location = '../view/view-kitchen-orders.php?msg=$msg';</script>";
            exit();
        }
    
        break;
    
    

    default:
        echo "<script>window.location = '../view/login.php';</script>";
        exit();
}
