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
            $paid_amount = $_POST['paid_amount'];
            $new_paid_amount = $_POST['new_paid_amount'];
            $old_due_amount = $_POST['due_amount'];
            $new_due_amount = $_POST['new_due_amount'];
            $new_payment_method = $_POST['new_payment_method'];

            if (empty($receipt_no) || empty($new_paid_amount) || empty($paid_amount) || empty($new_due_amount) || empty($new_payment_method)) {
                throw new Exception("Missing required fields.");
            }

            // Determine payment status
            if ($new_paid_amount < $old_due_amount) {
                $payment_status = "Partially Paid";
            } else {
                $payment_status = "Fully Paid";
            }

            $total_paid_amount = $paid_amount + $new_paid_amount;

            // Update Order
            $purchasingObj->updateOrder($receipt_no, $payment_status, $total_paid_amount, $new_due_amount, $new_payment_method);

            // Save Payment
            //Update: use receipt_no to get next payment_id
            $payment_id = $purchasingObj->getNextPaymentId($receipt_no);
            $purchasingObj->savePayment($payment_id, $receipt_no, $total_amount, $new_paid_amount, $new_due_amount, $new_payment_method);

            $msg = base64_encode("Payment Updated successfully.");
            echo "<script>window.location = '../view/receipt-payment.php?msg=$msg';</script>";
            exit();

        } catch (Exception $ex) {
            $msg = base64_encode("Error: " . $ex->getMessage());
            echo "<script>window.location = '../view/receipt-payment.php?msg=$msg';</script>";
            exit();
        }

        break;

        case "reverse_payment":
            try {
                $receipt_no = $_POST['receipt_no'];
        
                if (empty($receipt_no)) {
                    throw new Exception("Receipt number is required.");
                }
        
                // Get last payment by payment_id
                $lastPayment = $purchasingObj->getLastPaymentByReceiptNo($receipt_no);
                if (!$lastPayment) {
                    throw new Exception("No payment found to reverse.");
                }
        
                $reversedAmount = $lastPayment['paid_amount'];
        
                // Delete the last payment
                $purchasingObj->deleteLastPayment($lastPayment['Id']);
        
                // Get current order
                $order = $purchasingObj->getOrderByReceiptNo($receipt_no);
                $newPaidAmount = $order['paid_amount'] - $reversedAmount;
                $newDueAmount = $order['due_amount'] + $reversedAmount;
        
                $payment_status = "Unpaid";
                if ($newPaidAmount > 0 && $newDueAmount > 0) {
                    $payment_status = "Partially Paid";
                } elseif ($newPaidAmount > 0 && $newDueAmount == 0) {
                    $payment_status = "Fully Paid";
                }
        
                $purchasingObj->updateOrderAfterReversal($receipt_no, $newPaidAmount, $newDueAmount, $payment_status);
        
                $msg = base64_encode("Last payment reversed successfully.");
                echo "<script>window.location = '../view/payment-reversal.php?receipt_no=$receipt_no&msg=$msg';</script>";
                exit();
        
            } catch (Exception $ex) {
                $msg = base64_encode("Error: " . $ex->getMessage());
                echo "<script>window.location = '../view/payment-reversal.php?receipt_no=$receipt_no&msg=$msg';</script>";
                exit();
            }
        

    default:
        echo "<script>window.location = '../view/login.php';</script>";
        exit();
}
