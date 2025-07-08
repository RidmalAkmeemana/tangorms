<?php
include '../commons/session.php';
include_once '../model/pos_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
    echo "<script>window.location = '../view/login.php';</script>";
    exit();
}

$status = $_GET["status"];
$posObj = new POS();

switch ($status) {

    case "submit_order":

        try {
            $receipt_no = $_POST['receipt_no'];
            $customer_id = $_POST['customer_id'];
            $sub_total_amount = $_POST['sub_total_amount'];
            $discount = $_POST['discount'];
            $total_amount = $_POST['total_amount'];
            $paid_amount = $_POST['paid_amount'];
            $balance = $_POST['balance'];
            $due_amount = $_POST['due_amount'];
            $payment_method = $_POST['payment_method'];
            $order_type = $_POST['order_type'];
            $table_id = isset($_POST['table_id']) ? $_POST['table_id'] : null;

            $item_codes = $_POST['item_code'];
            $item_names = $_POST['item_name'];
            $item_prices = $_POST['item_price'];
            $item_qtys = $_POST['item_qty'];
            $total_prices = $_POST['total_price'];

            if (empty($receipt_no) || empty($customer_id) || empty($item_codes)) {
                throw new Exception("Missing required fields.");
            }

            // Determine payment status
            if ($paid_amount == 0) {
                $payment_status = "Unpaid";
            } elseif ($paid_amount < $total_amount) {
                $payment_status = "Partially Paid";
            } else {
                $payment_status = "Fully Paid";
            }

            // Save Order
            $posObj->saveOrder($receipt_no, $customer_id, $payment_status, $sub_total_amount, $discount, $total_amount, $paid_amount, $balance, $due_amount, $payment_method, $order_type, $table_id);

            // Save Order Items and update item stock
            for ($i = 0; $i < count($item_codes); $i++) {
                $posObj->saveOrderItem($receipt_no, $item_codes[$i], $item_names[$i], $item_prices[$i], $item_qtys[$i], $total_prices[$i]);
                $posObj->updateItemQty($item_codes[$i], $item_qtys[$i]); // Update stock
            }

            // Save Payment if needed
            if ($payment_status !== "Unpaid") {
                //Update: use receipt_no to get next payment_id
                $payment_id = $posObj->getNextPaymentId($receipt_no);
                $posObj->savePayment($payment_id, $receipt_no, $total_amount, $paid_amount, $balance, $due_amount, $payment_method);
            }

            // Vacate the table if Dine-In
            if ($order_type === 'Dine-In' && $table_id) {
                $posObj->vacateTable($table_id);
            }

            // Update invoice number
            $posObj->updateInvoiceNo();

            // Open receipt PDF in new tab
            echo "<script>
            const win = window.open('../view/print-receipt.php?receipt_no=$receipt_no', '_blank');
            if (!win) {
                alert('Please allow popups for this site to print the receipt.');
            }
            </script>";

            $msg = base64_encode("Order submitted successfully.");
            echo "<script>window.location = '../view/pos-sale.php?msg=$msg';</script>";
            exit();

        } catch (Exception $ex) {
            $msg = base64_encode("Error: " . $ex->getMessage());
            echo "<script>window.location = '../view/pos-sale.php?msg=$msg';</script>";
            exit();
        }

        break;

    default:
        echo "<script>window.location = '../view/login.php';</script>";
        exit();
}
