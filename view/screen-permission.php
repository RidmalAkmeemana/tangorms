<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/permission_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

//get user information from session
$userrow = $_SESSION["user"];

$permissionObj = new Permission();

$user_id = isset($_GET["user_id"]) ? base64_decode($_GET["user_id"]) : null;

$roleResult = $permissionObj->getAllRoles();
$userRow = [];
$userResult = $permissionObj->getUser($user_id);
if ($userResult && $userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
}

$selectedRoleId = isset($_GET["role_id"]) ? $_GET["role_id"] : ($userRow["user_role"] ?? null);
$userFunctionIds = $selectedRoleId ? $permissionObj->getFunctionsByRole($selectedRoleId) : [];

$allModules = $permissionObj->getAllModules();
?>

<!DOCTYPE html>
<html>
<head>
    <?php include_once "../includes/bootstrap_css_includes.php"; ?>
    <style>
        body {
            background-color: #5c5b5b;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .container { padding-top: 30px; }
        label.control-label { color: white; font-weight: 500; }
        .panel, .panel-body {
            background-color: #faf7f7;
            border: 1px solid #FF6600;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
            color: #333;
        }
        .panel-heading {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 16px;
        }
        .function-checkbox label {
            display: block;
            color: #333;
            font-weight: 500;
        }
        input.form-control, select.form-control {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            color: #333;
        }
        .mt-3 { margin-top: 20px; }
        .mt-4 { margin-top: 30px; }
        .mb-2 { margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <?php $pageName = "USER MANAGEMENT"; ?>
    <?php include_once "../includes/header_row_includes.php"; ?>
    <?php require 'role-management-sidebar.php'; ?>

    <form action="../controller/screen_controller.php?status=update_permissions" method="post">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
        <input type="hidden" name="user_role" id="hidden_user_role" value="<?= htmlspecialchars($selectedRoleId) ?>">
        <div id="module-container"></div>

        <div class="col-md-9">
            <?php if (isset($_GET["msg"])): ?>
                <div class="row">
                    <div class="alert alert-success">
                        <?= base64_decode($_GET["msg"]); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="col-md-2">
                    <label class="control-label">User Role</label> <label class="text-danger">*</label>
                </div>
                <div class="col-md-4">
                    <select name="role_id" class="form-control" id="user_role" required>
                        <option value="">---Select User Role---</option>
                        <?php if ($roleResult && $roleResult->num_rows > 0): ?>
                            <?php while ($roleRow = $roleResult->fetch_assoc()): ?>
                                <option value="<?= $roleRow["role_id"] ?>" <?= ($roleRow["role_id"] == $selectedRoleId) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($roleRow["role_name"]) ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Permissions Section -->
            <div id="permission-section" class="row mt-4" style="display: <?= $selectedRoleId ? 'block' : 'none' ?>;">
                <div class="col-md-12">
                    <h4>Permissions</h4>
                    <?php if ($allModules && $allModules->num_rows > 0): ?>
                        <?php while ($module = $allModules->fetch_assoc()):
                            $functionsResult = $permissionObj->getFunctionsByModule($module['module_id']);
                            $functionList = [];
                            $masterFunctions = [];

                            if ($functionsResult && $functionsResult->num_rows > 0) {
                                while ($func = $functionsResult->fetch_assoc()) {
                                    $functionList[] = $func;
                                    if (in_array($func['function_id'], [1, 8, 14, 27])) {
                                        $masterFunctions[] = $func['function_id'];
                                    }
                                }
                            }

                            if (count($functionList) > 0):
                                $masterDataAttr = implode(',', $masterFunctions);
                        ?>
                        <div class="panel panel-default mt-3" 
                             data-master="<?= $masterDataAttr ?>" 
                             data-module-id="<?= $module['module_id'] ?>">
                            <div class="panel-heading"><?= htmlspecialchars($module['module_name']); ?></div>
                            <div class="panel-body">
                                <div class="row">
                                    <?php foreach ($functionList as $func): ?>
                                        <div class="col-md-3 function-checkbox mb-2">
                                            <label>
                                                <input type="checkbox" name="functions[]" value="<?= $func['function_id'] ?>"
                                                    <?= in_array($func['function_id'], $userFunctionIds) ? 'checked' : '' ?>>
                                                <?= htmlspecialchars($func['function_name']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div id="role-warning" class="row mt-4 text-center" style="display: <?= !$selectedRoleId ? 'block' : 'none' ?>;">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        Please select a user role to manage permissions.
                    </div>
                </div>
            </div>

            <div class="row mt-3 text-center">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-danger" value="Reset">
                </div>
            </div>
        </div>
    </form>
</div>

<script src="../js/jquery-3.7.1.js"></script>
<script>
$(document).ready(function () {
    const userId = "<?= base64_encode($user_id) ?>";

    $('#user_role').on('change', function () {
        const roleId = $(this).val();
        if (roleId !== '') {
            window.location.href = "screen-permission.php?user_id=" + userId + "&role_id=" + roleId;
        } else {
            $('#permission-section').hide();
            $('#role-warning').show();
        }
    });

    function updateModuleInputs() {
        $('#module-container').empty();
        $('.panel').each(function () {
            const panel = $(this);
            const moduleId = panel.data('module-id');
            const masterAttr = panel.attr('data-master');
            if (!masterAttr) return;

            const masterIds = masterAttr.split(',').map(id => id.trim());
            const isMasterChecked = masterIds.some(id =>
                panel.find(`input[type="checkbox"][value="${id}"]`).prop('checked')
            );

            if (isMasterChecked) {
                $('#module-container').append(`<input type="hidden" name="enabled_modules[]" value="${moduleId}">`);
            }
        });
    }

    function toggleFunctionCheckboxes(panel) {
        const masterAttr = panel.attr('data-master');
        if (!masterAttr) return;

        const masterIds = masterAttr.split(',').map(id => id.trim());
        const isAnyMasterChecked = masterIds.some(id =>
            panel.find(`input[type="checkbox"][value="${id}"]`).prop('checked')
        );

        panel.find('input[type="checkbox"]').each(function () {
            const val = $(this).val();
            if (masterIds.includes(val)) return;
            $(this).prop('disabled', !isAnyMasterChecked);
            if (!isAnyMasterChecked) $(this).prop('checked', false);
        });
    }

    $('.panel').each(function () {
        const panel = $(this);
        toggleFunctionCheckboxes(panel);
    });

    $('.panel input[type="checkbox"]').on('change', function () {
        const panel = $(this).closest('.panel');
        toggleFunctionCheckboxes(panel);
        updateModuleInputs();
    });

    updateModuleInputs();
});
</script>
</body>
</html>
