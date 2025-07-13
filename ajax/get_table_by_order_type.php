<?php
include_once '../model/pos_model.php';

$customer_id = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;
$today = date('Y-m-d');
$tables = [];

// Check reservation for today for this customer
$reservedTableSql = "
    SELECT r.table_id, t.table_name
    FROM reservations r
    JOIN `table` t ON r.table_id = t.table_id
    WHERE r.customer_id = ? AND DATE(r.reserved_date) = ? AND r.reservation_status = 'Reserved'
    LIMIT 1
";

$stmt = $con->prepare($reservedTableSql);
$stmt->bind_param("is", $customer_id, $today);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    // If reserved table exists, return only it
    $tables[] = [
        'table_id' => $row['table_id'],
        'table_name' => $row['table_name']
    ];
} else {
    // If no reservation, get all vacant tables
    $fallbackSql = "SELECT table_id, table_name FROM `table` WHERE table_status IN ('Vacant', 'Reserved')";
    $result = $con->query($fallbackSql);

    while ($row = $result->fetch_assoc()) {
        $tables[] = [
            'table_id' => $row['table_id'],
            'table_name' => $row['table_name']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($tables);
exit;
