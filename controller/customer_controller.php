<?php
include '../commons/session.php';
include_once '../model/customer_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$customerObj = new Customer();
$loginObj = new Login();

switch ($status) {

    case "add_item":

        $customer_nic = $_POST["customer_nic"];
        $customer_name = $_POST["customer_name"];
        $customer_mobile = $_POST["customer_mobile"];
        $customer_address = isset($_POST["customer_address"]) && trim($_POST["customer_address"]) !== "" ? $_POST["customer_address"] : null;
    
        try {
            if ($customer_nic == "") {
                throw new Exception("Customer NIC Cannot be Empty");
            }
            if ($customer_name == "") {
                throw new Exception("Customer Name Cannot be Empty");
            }
    
            if ($customer_mobile == "") {
                throw new Exception("Customer Mobile Cannot be Empty");
            }
    
            // Call addCustomer
            $customer_id = $customerObj->addCustomer($customer_nic, $customer_name, $customer_mobile, $customer_address);
    
            $msg = "$customer_name Successfully Added !! ";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-customers.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/add-customer.php?msg=<?php echo $msg; ?>";
            </script>
    <?php
        }
    
        break;
    

        case "activate":
            if (!isset($_GET['customer_id'])) {
                $msg = base64_encode("Customer ID is missing!");
                echo "<script>window.location = '../view/view-customers.php?msg=$msg';</script>";
                exit;
            }
        
            $customer_id = base64_decode($_GET['customer_id']);
        
            // Call activate function
            if ($customerObj->activate($customer_id)) {
                $msg = base64_encode("Successfully Activated !!!");
            } else {
                $msg = base64_encode("Activation Failed!");
            }
            ?>
            <script>
                window.location = "../view/view-customers.php?msg=<?= $msg ?>";
            </script>
            <?php
            break;
    
            case "deactivate":
                if (!isset($_GET['customer_id'])) {
                    $msg = base64_encode("Customer ID is missing!");
                    echo "<script>window.location = '../view/view-customers.php?msg=$msg';</script>";
                    exit;
                }
            
                $customer_id = base64_decode($_GET['customer_id']);
            
                // Call deactivate function
                if ($customerObj->deactivate($customer_id)) {
                    $msg = base64_encode("Successfully Deactivated !!!");
                } else {
                    $msg = base64_encode("Deactivation Failed!");
                }
                ?>
                <script>
                    window.location = "../view/view-customers.php?msg=<?= $msg ?>";
                </script>
                <?php
                break;
            

            case "update_customer":

                $customer_id = $_POST["customer_id"];
                $customer_nic = $_POST["customer_nic"];
                $customer_name = $_POST["customer_name"];
                $customer_mobile = $_POST["customer_mobile"];
                $customer_address = isset($_POST["customer_address"]) && trim($_POST["customer_address"]) !== "" ? $_POST["customer_address"] : null;
        
                try {
                    if ($customer_id == "") {
                        throw new Exception("Customer Id Cannot be Empty");
                    }
        
                    if ($customer_nic == "") {
                        throw new Exception("Customer NIC be Empty");
                    }
        
                    if ($customer_name == "") {
                        throw new Exception("Customer Name be Empty");
                    }
                    if ($customer_mobile == "") {
                        throw new Exception("Custoomer Mobile be Empty");
                    }
        
                    $customerResult = $customerObj->getCustomer($customer_id);
                    $customerRow = $customerResult->fetch_assoc();
                    
                    //update customer
                    $customerObj->UpdateCustomer($customer_nic, $customer_name, $customer_mobile, $customer_address, $customer_id);
        
                    $msg = "Customer Updated Successfully";
                    $msg = base64_encode($msg);
                ?>
                    <script>
                        window.location = "../view/view-customers.php?msg=<?php echo $msg; ?>";
                    </script>
                <?php
        
                } catch (Exception $ex) {
        
                    $msg = $ex->getMessage();
                    $msg = base64_encode($msg);
                ?>
                    <script>
                        window.location = "../view/edit-customer.php?msg=<?php echo $msg; ?>";
                    </script>
        <?php
                }
        
        
                break;

                case "delete":

                    // Ensure user is logged in
                    if (!isset($_SESSION['user'])) {
                        echo "<script>alert('Unauthorized access!'); window.location.href = '../view/login.php';</script>";
                        exit;
                    }
                
                    // Validate customer_id parameter
                    if (!isset($_GET['customer_id'])) {
                        echo "<script>alert('Missing Customer ID!'); window.location.href = '../view/view-customers.php';</script>";
                        exit;
                    }
                
                    $customer_id = base64_decode($_GET['customer_id']);
                    $current_user_id = $_SESSION['user']['user_id'];
                
                    // Load user model to check permissions
                    include_once '../model/user_model.php';
                    $userObj = new User();
                    $accessibleFunctions = $userObj->getAccessibleFunctionsWithModule($current_user_id);
                
                    // Check for delete permission (assuming function_id 26 = delete room)
                    $hasDeletePermission = false;
                    foreach ($accessibleFunctions as $func) {
                        if (
                            strtolower($func['function_url']) === 'customer_controller.php' &&
                            (int)$func['function_id'] === 103
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
                        $customerObj->delete($customer_id); // Ensure this function updates item_status or actually deletes
                        $msg = base64_encode("Customer deleted successfully.");
                        echo "<script>window.location.href = '../view/view-customers.php?msg=$msg';</script>";
                    } catch (Exception $e) {
                        $error = base64_encode("Error deleting Customer: " . $e->getMessage());
                        echo "<script>window.location.href = '../view/view-customers.php?msg=$error';</script>";
                    }
                
                    break;
}
