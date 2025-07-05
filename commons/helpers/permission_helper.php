<?php
include_once '../model/user_model.php';

function checkFunctionPermission($currentFilePath)
{
    // Extract only the file name (e.g., "/user.php" → "user.php")
    $filename = basename($currentFilePath);

    // Check if user session exists
    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
        exit;
    }

    $user = $_SESSION['user'];
    $user_id = $user["user_id"];

    $userObj = new User();
    $accessibleFunctions = $userObj->getAccessibleFunctionsWithModule($user_id);

    $hasAccess = false;

    foreach ($accessibleFunctions as $func) {
        if ($func['function_url'] === $filename) {
            $hasAccess = true;
            break;
        }
    }

    if (!$hasAccess) {
        echo "<script>alert('Access Denied!'); window.location.href = 'dashboard.php';</script>";
        exit;
    }
}