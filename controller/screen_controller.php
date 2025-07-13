<?php
// File: screen_controller.php
include '../commons/session.php';
include_once '../model/permission_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
    echo "<script>window.location = '../view/login.php';</script>";
    exit();
}

$status = $_GET["status"];
$permissionObj = new Permission();

switch ($status) {
    case "update_permissions":

        $role_id = $_POST["role_id"];
        $user_id = $_POST["user_id"];
        $selectedFunctions = isset($_POST["functions"]) ? $_POST["functions"] : [];

        try {
            if (empty($role_id)) {
                throw new Exception("Role ID is required");
            }

            $currentFunctions = $permissionObj->getFunctionsByRole($role_id);
            $toInsert = array_diff($selectedFunctions, $currentFunctions);
            $toDelete = array_diff($currentFunctions, $selectedFunctions);

            $mainFunctionIds = [1, 8, 14, 27, 95, 99, 111, 115, 119, 123, 129, 136];

            foreach ($toInsert as $function_id) {
                $permissionObj->addRoleFunction($role_id, $function_id);

                if (in_array($function_id, $mainFunctionIds)) {
                    $module_id = $permissionObj->getModuleIdByFunctionId($function_id);
                    if ($module_id) {
                        $permissionObj->addRoleModule($role_id, $module_id);
                    }
                }
            }

            foreach ($toDelete as $function_id) {
                $permissionObj->removeRoleFunction($role_id, $function_id);

                if (in_array($function_id, $mainFunctionIds)) {
                    $module_id = $permissionObj->getModuleIdByFunctionId($function_id);
                    if ($module_id) {
                        $permissionObj->removeRoleModule($role_id, $module_id);
                    }
                }
            }

            $msg = base64_encode("Permissions Updated Successfully");
            echo "<script>window.location = '../view/screen-permission.php?user_id=" . base64_encode($user_id) . "&role_id={$role_id}&msg={$msg}';</script>";
        } catch (Exception $ex) {
            $msg = base64_encode($ex->getMessage());
            echo "<script>window.location = '../view/screen-permission.php?user_id=" . base64_encode($user_id) . "&role_id={$role_id}&msg={$msg}';</script>";
        }

        break;

    default:
        echo "<script>window.location = '../view/login.php';</script>";
        break;
}
