<?php
include '../commons/session.php';
include_once '../model/purchasing_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
    echo "<script>window.location = '../view/login.php';</script>";
    exit();
}

$status = $_GET["status"];
$purchasingObj = new Purchasing();

switch ($status) {

    case "update_order":
        try {
            $receipt_no = $_POST['receipt_no'];
            $total_amount = $_POST['total_amount'];
            $balance = $_POST['balance'];
            $new_paid_amount = $_POST['new_paid_amount'];
            $old_due_amount = $_POST['due_amount'];
            $new_due_amount = $_POST['new_due_amount'];
            $new_payment_method = $_POST['new_payment_method'];

            if (empty($receipt_no) || empty($new_paid_amount) || empty($new_due_amount) || empty($new_payment_method)) {
                throw new Exception("Missing required fields.");
            }

            // Determine payment status
            if ($new_paid_amount < $old_due_amount) {
                $payment_status = "Partially Paid";
            } else {
                $payment_status = "Fully Paid";
            }

            // Update Order
            $purchasingObj->updateOrder($receipt_no, $payment_status, $new_paid_amount, $new_due_amount, $new_payment_method);

            // Save Payment
            //Update: use receipt_no to get next payment_id
            $payment_id = $posObj->getNextPaymentId($receipt_no);
            $purchasingObj->savePayment($payment_id, $receipt_no, $total_amount, $new_paid_amount, $balance, $new_due_amount, $new_payment_method);

            $msg = base64_encode("Payment Updated successfully.");
            echo "<script>window.location = '../view/receipt-payment.php?msg=$msg';</script>";
            exit();

        } catch (Exception $ex) {
            $msg = base64_encode("Error: " . $ex->getMessage());
            echo "<script>window.location = '../view/receipt-payment.php?msg=$msg';</script>";
            exit();
        }

        break;

    default:
        echo "<script>window.location = '../view/login.php';</script>";
        exit();
}
