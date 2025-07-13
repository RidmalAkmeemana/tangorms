<?php
include '../commons/session.php';
include_once '../model/reservation_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$reservationObj = new Reservation();
$loginObj = new Login();

switch ($status) {

    case "add_reservation":

        $reservation_no = $_POST["reservation_no"];
        $customer_id = $_POST["customer_id"];
        $table_id = $_POST["table_id"];
        $reserved_date = $_POST["reserved_date"];

        try {
            if (empty($reservation_no)) {
                throw new Exception("Reservation Number cannot be empty");
            }

            if (empty($customer_id)) {
                throw new Exception("Customer cannot be empty");
            }

            if (empty($table_id)) {
                throw new Exception("Table selection is required");
            }

            if (empty($reserved_date)) {
                throw new Exception("Reservation Date is required");
            }

            // Check if the table is already reserved for that date
            if ($reservationObj->isTableReserved($table_id, $reserved_date)) {
                throw new Exception("This table is already reserved for the selected date.");
            }

            // Add reservation
            $reservation_id = $reservationObj->addReservation(
                $reservation_no,
                $customer_id,
                $table_id,
                $reserved_date
            );

            // Update table status
            $reservationObj->markTableAsReserved($table_id);

            // Update reservation number
            $reservationObj->updateReservationNo();

            $msg = "Reservation $reservation_no added successfully!";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-reservations.php?msg=<?= $msg ?>";
            </script>
        <?php
        } catch (Exception $ex) {
            $msg = base64_encode($ex->getMessage());
        ?>
            <script>
                alert("<?= base64_decode($msg) ?>");
                window.location = "../view/add-reservation.php?msg=<?= $msg ?>";
            </script>
        <?php
        }

        break;

        case "update_reservation":

            $reservation_no = $_POST["reservation_no"];
            $table_id = $_POST["table_id"];
            $reserved_date = $_POST["reserved_date"];
            $reservation_status = $_POST["reservation_status"];
        
            try {
                if (empty($reservation_no)) {
                    throw new Exception("Reservation Number cannot be empty");
                }
        
                if (empty($table_id)) {
                    throw new Exception("Table selection is required");
                }
        
                if (empty($reserved_date)) {
                    throw new Exception("Reservation Date is required");
                }
        
                if (empty($reservation_status)) {
                    throw new Exception("Reservation Status is required");
                }
        
                // Get current reservation details to compare
                $currentReservation = $reservationObj->getReservationByReservationNo($reservation_no);
                $current_table_id = $currentReservation['table_id'];
                $current_reserved_date = date('Y-m-d', strtotime($currentReservation['reserved_date']));
        
                // Only check for conflict if table or date is being changed
                if (
                    ($table_id != $current_table_id || $reserved_date != $current_reserved_date) &&
                    $reservationObj->isTableReserved($table_id, $reserved_date)
                ) {
                    throw new Exception("This table is already reserved for the selected date.");
                }
        
                // Edit reservation
                $reservationObj->editReservation(
                    $reservation_no,
                    $table_id,
                    $reserved_date,
                    $reservation_status
                );
        
                // If the table is changed, check if old table has other active reservations
                if ($table_id != $current_table_id) {
                    if (!$reservationObj->hasOtherActiveReservations($current_table_id, $reservation_no)) {
                        $reservationObj->markTableAsVacant($current_table_id);
                    }
                }
        
                // If reservation is canceled, mark new table as vacant only if no other active reservations exist
                if ($reservation_status === 'Canceled') {
                    if (!$reservationObj->hasOtherActiveReservations($table_id, $reservation_no)) {
                        $reservationObj->markTableAsVacant($table_id);
                    }
                } else {
                    $reservationObj->markTableAsReserved($table_id);
                }
        
                $msg = "Reservation $reservation_no updated successfully!";
                $msg = base64_encode($msg);
        ?>
                <script>
                    window.location = "../view/view-reservations.php?msg=<?= $msg ?>";
                </script>
        <?php
            } catch (Exception $ex) {
                $msg = base64_encode($ex->getMessage());
        ?>
                <script>
                    alert("<?= base64_decode($msg) ?>");
                    window.location = "../view/view-reservations.php?msg=<?= $msg ?>";
                </script>
        <?php
            }
        
            break;
        
        
        
}
