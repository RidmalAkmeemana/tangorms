<?php
include_once '../model/menu_model.php';

if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];

    $menuObj = new Menu();
    $itemResult = $menuObj->getItem($item_id);

    $items = [];
    while ($row = $itemResult->fetch_assoc()) {
        $items[] = [
            'item_id' => $row['item_id'],
            'item_code' => $row['item_code'],
            'item_image' => $row['item_image'],
            'item_name' => $row['item_name'],
            'item_price' => $row['item_price'],
            'item_qty' => $row['item_qty']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($items);
    exit;
}

echo json_encode([]);

?>

