<?php
include '../commons/session.php';
include_once '../model/role_model.php';
include_once '../model/login_model.php';

if (!isset($_GET["status"])) {
?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
}

$status = $_GET["status"];

$roleObj = new Role();
$loginObj = new Login();

switch ($status) {

    case "add_role":

        $role_name = $_POST["role_name"];
        $role_status = $_POST["role_status"];

        try {
            if ($role_name == "") {
                throw new Exception("Role Name Cannot be Empty");
            }

            // Passing data to the addRole() of the Module page

            $role_id = $roleObj->addRole($role_name);

            $msg = "Role $role_name Successfully Added !! ";
            $msg = base64_encode($msg);
    ?>
            <script>
                window.location = "../view/view-roles.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/add-role.php?msg=<?php echo $msg; ?>";
            </script>
        <?php
        }


        break;

    //active a role

    case "activate":
        $role_id = $_GET['role_id'];
        $role_id = base64_decode($role_id);
        $roleObj->activateRole($role_id);

        $msg = "Successfully Activated !!!";
        $msg = base64_encode($msg);
        ?>
        <script>
            window.location = "../view/view-roles.php?msg=<?php echo $msg; ?>";
        </script>
    <?php
        break;

    case "deactivate":
        $role_id = $_GET['role_id'];
        $role_id = base64_decode($role_id);
        $roleObj->deactivateRole($role_id);

        $msg = "Successfully Dectivated !!!";
        $msg = base64_encode($msg);
    ?>
        <script>
            window.location = "../view/view-roles.php?msg=<?php echo $msg; ?>";
        </script>
    <?php
        break;

    case "delete":
        $role_id = $_GET['role_id'];
        $role_id = base64_decode($role_id);
        $roleObj->deleteRole($role_id);

        $msg = "Successfully Deleted !!!";
        $msg = base64_encode($msg);
    ?>
        <script>
            window.location = "../view/view-roles.php?msg=<?php echo $msg; ?>";
        </script>
        <?php
        break;

    case "update_role":

        $role_id = $_POST["role_id"];
        $role_name = $_POST["role_name"];

        try {
            if ($role_id == "") {
                throw new Exception("Role Id Cannot be Empty");
            }
            if ($role_name == "") {
                throw new Exception("Role Name Cannot be Empty");
            }

            $roleResult = $roleObj->getRole($role_id);
            $roleRow = $roleResult->fetch_assoc();
            //update role
            $roleObj->UpdateRole($role_id, $role_name);

            $msg = "Role Updated Successfully";
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/view-roles.php?msg=<?php echo $msg; ?>";
            </script>
        <?php

        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
        ?>
            <script>
                window.location = "../view/edit-role.php?msg=<?php echo $msg; ?>";
            </script>
<?php
        }


        break;
}
