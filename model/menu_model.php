<?php

include_once '../commons/db_connection.php';

$dbcon = new DbConnection();

class Menu
{
    public function addCategory($category_name)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("
        INSERT INTO `categories` (category_name, category_status)
        VALUES (?, 1)
    ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("s", $category_name);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $category_id = $stmt->insert_id;
        $stmt->close();

        return $category_id;
    }

    public function updateCategory($category_id, $category_name)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `categories` 
            SET category_name = ?
            WHERE category_id = ?";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        // s = string, s = string, i = integer, i = integer
        $stmt->bind_param("si", $category_name, $category_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows > 0;
    }


    public function getAllCategory()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM categories WHERE category_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function activateCategories($category_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE categories SET category_status='1' WHERE category_id ='$category_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function deactivateCategories($category_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE categories SET category_status='0' WHERE category_id ='$category_id'";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getCategory($category_id)
{
    $con = $GLOBALS["con"];

    $stmt = $con->prepare("
        SELECT 
            c.category_id, 
            c.category_name,  
            c.category_status,
            i.item_name,
            i.item_status
        FROM categories AS c
        LEFT JOIN `item` AS i 
            ON i.item_category = c.category_id AND i.item_status != -1
        WHERE c.category_id = ?
    ");

    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


    public function getCategoryCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN category_status = '1' THEN 1 END) AS category_count
                FROM `categories`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function getItemCounts()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT 
                    COUNT(CASE WHEN item_status = '1' THEN 1 END) AS item_count
                FROM `item`";
        $result = $con->query($sql) or die($con->error);
        return $result->fetch_assoc();
    }

    public function deleteCategory($category_id)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("UPDATE `categories` SET category_status = '-1' WHERE category_id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function addItems($item_name, $item_description, $item_price, $item_category, $item_qty, $file_name)
    {
        $con = $GLOBALS["con"];
        $stmt = $con->prepare("
        INSERT INTO `item` (item_name, item_description, item_price, item_category, item_qty, item_image, item_status)
        VALUES (?, ?, ?, ?, ?, ?, 1)
    ");

        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("ssdiis", $item_name, $item_description, $item_price, $item_category, $item_qty, $file_name);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $item_id = $stmt->insert_id;
        $stmt->close();

        return $item_id;
    }

    public function getAllItems()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM items WHERE item_status != -1";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}
