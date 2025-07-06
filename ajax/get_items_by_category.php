<?php
include_once '../model/pos_model.php';

if (isset($_GET['category_id'])) {
    $category_id = (int)$_GET['category_id'];

    $posObj = new POS();
    $itemsResult = $posObj->getItems($category_id);

    $items = [];
    while ($row = $itemsResult->fetch_assoc()) {
        $items[] = [
            'item_id' => $row['item_id'],
            'item_name' => $row['item_name']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($items);
    exit;
}

echo json_encode([]);
?>