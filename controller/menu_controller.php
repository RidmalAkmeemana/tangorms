<?php
include '../commons/session.php';
include_once '../model/menu_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$menuObj = new Menu();
$loginObj = new Login();

switch ($status) {

    case "add_category":

    $category_name = $_POST["category_name"];

    try {
        if (empty($category_name)) {
            throw new Exception("Category Name cannot be empty");
        }

        // Call the model method
        $category_id = $menuObj->addCategory($category_name);

        $msg = base64_encode("$category_name Successfully Added!");
        echo "<script>window.location = '../view/view-categories.php?msg={$msg}';</script>";
    } catch (Exception $ex) {
        $msg = base64_encode($ex->getMessage());
        echo "<script>window.location = '../view/view-categories.php?msg={$msg}';</script>";
    }

    break;

    case "delete":
    session_start();

    // Ensure user is logged in
    if (!isset($_SESSION['user'])) {
        echo "<script>alert('Unauthorized access!'); window.location.href = '../view/login.php';</script>";
        exit;
    }

    // Validate category_id parameter
    if (!isset($_GET['category_id'])) {
        echo "<script>alert('Missing Room ID!'); window.location.href = '../view/view-categories.php';</script>";
        exit;
    }

    $category_id = base64_decode($_GET['category_id']);
    $current_user_id = $_SESSION['user']['user_id'];

    // Load user model to check permissions
    include_once '../model/user_model.php';
    $userObj = new User();
    $accessibleFunctions = $userObj->getAccessibleFunctionsWithModule($current_user_id);

    // Check for delete permission (assuming function_id 26 = delete room)
    $hasDeletePermission = false;
    foreach ($accessibleFunctions as $func) {
        if (
            strtolower($func['function_url']) === 'menu_controller.php' &&
            (int)$func['function_id'] === 34
        ) {
            $hasDeletePermission = true;
            break;
        }
    }

    // If no permission
    if (!$hasDeletePermission) {
        echo "<script>alert('Access Denied!'); window.location.href = '../view/dashboard.php';</script>";
        exit;
    }

    try {
        $menuObj->deleteCategory($category_id); // Ensure this function updates room_status or actually deletes
        $msg = base64_encode("Category deleted successfully.");
        echo "<script>window.location.href = '../view/view-categories.php?msg=$msg';</script>";
    } catch (Exception $e) {
        $error = base64_encode("Error deleting category: " . $e->getMessage());
        echo "<script>window.location.href = '../view/view-categories.php?msg=$error';</script>";
    }

    break;

    case "activate":
        $category_id = $_GET['category_id'];
        $category_id = base64_decode($category_id);
        $menuObj->activateCategories($category_id);

        $msg = "Successfully Activated !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-categories.php?msg=<?php echo $msg; ?>";
        </script>
    <?php
        break;

    case "deactivate":
        $category_id = $_GET['category_id'];
        $category_id = base64_decode($category_id);
        $menuObj->deactivateCategories($category_id);

        $msg = "Successfully Dectivated !!!";
        $msg = base64_encode($msg);
    ?>
        <script>
            window.location = "../view/view-categories.php?msg=<?php echo $msg; ?>";
        </script>
    <?php
        break;

    case "update_category":

        $category_id = $_POST["category_id"];
        $category_name = $_POST["category_name"];

        try {
            if ($category_id == "") {
                throw new Exception("Category Id Cannot be Empty");
            }
            if ($category_name == "") {
                throw new Exception("Category Name Cannot be Empty");
            }

            $tableResult = $menuObj->getCategory($category_id);
            $tableRow = $tableResult->fetch_assoc();
            //update table
            $menuObj->updateCategory($category_id, $category_name);

            $msg = "Table Updated Successfully";
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/view-categories.php?msg=<?php echo $msg; ?>";
            </script>
        <?php

        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/edit-category.php?msg=<?php echo $msg; ?>";
            </script>
<?php
        }

        break;

        case "add_item":

        $item_name = $_POST["item_name"];
        $item_description = $_POST["item_description"];
        $item_price = $_POST["item_price"];
        $item_category = $_POST["item_category"];
        $item_qty = $_POST["item_qty"];
        $item_image = $_FILES["item_image"];

        try {
            if ($item_name == "") {
                throw new Exception("Item Name Cannot be Empty");
            }

            if ($item_description == "") {
                throw new Exception("Item Description Cannot be Empty");
            }

            if ($item_price == "") {
                throw new Exception("Item Price Cannot be Empty");
            }

            if ($item_category == "") {
                throw new Exception("Item Category Cannot be Empty");
            }

            if ($item_qty == "") {
                throw new Exception("Qty Cannot be Empty");
            }

            if ($item_image == "") {
                throw new Exception("Item Image Cannot be Empty");
            }

            //uploading image

            $file_name = "";
            if (isset($_FILES["item_image"])) {

                if ($item_image["name"] != "") {

                    $file_name = time() . "_" . $user_image["name"];
                    $path = "../images/item_images/$file_name";
                    move_uploaded_file($room_layout["tmp_name"], $path);
                }
            }

            // Passing data to the addItem() of the Module page

            $item_id = $menuObj->addItems($item_name, $item_description, $item_price, $item_category, $item_qty, $file_name);

            $msg = "$item_name Successfully Added !! ";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-items.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/add-item.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        }


        break;
}
