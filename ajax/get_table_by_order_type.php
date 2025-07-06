<?php
include_once '../model/table_model.php';

$tableObj = new Table();
$tableResult = $tableObj->getAllTables(); // Replace with your actual table fetch method

$tables = [];
while ($row = $tableResult->fetch_assoc()) {
    $tables[] = [
        'table_id' => $row['table_id'],
        'table_name' => $row['table_name']
    ];
}

header('Content-Type: application/json');
echo json_encode($tables);
exit;
?>
