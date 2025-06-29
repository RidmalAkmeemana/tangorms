<?php
include '../commons/session.php';
include_once '../commons/helpers/permission_helper.php';
include_once '../model/user_model.php';

checkFunctionPermission($_SERVER['PHP_SELF']);

$userrow = $_SESSION["user"];
$user_id = $userrow["user_id"];

// Get user roles for dropdown
$userObj     = new User();
$roleResult  = $userObj->getAllRoles();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <?php include_once "../includes/bootstrap_css_includes.php"; ?>
    <style>
        body {
            background-color: #5c5b5b;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #FF6600;
            color: #333;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #FF6600;
            color: white;
        }

        .panel,
        .panel-body {
            background-color: #faf7f7;
            border: 1px solid #FF6600;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.3);
        }

        .panel-info>.panel-heading {
            background-color: #FF6600;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .container {
            padding-top: 30px;
        }

        label.control-label {
            color: white;
            font-weight: 500;
        }

        input.form-control,
        select.form-control {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            color: #333;
        }

        input.form-control:focus,
        select.form-control:focus {
            border-color: #FF6600;
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.6);
        }

        .btn-danger {
            background-color: #aa3333;
            border-color: #aa3333;
        }

        .btn-danger:hover {
            background-color: #992222;
            border-color: #992222;
        }

        #img_prev {
            border: 1px solid #ccc;
            padding: 2px;
            margin-top: 5px;
            border-radius: 4px;
        }

        .mt-3 {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $pageName = "USER MANAGEMENT";
        include_once "../includes/header_row_includes.php"; ?>

        <div class="row">
            <?php require 'user-management-sidebar.php'; ?>

            <form class="col-md-9" action="../controller/user_controller.php?status=add_user" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 alert alert-danger text-center">
                            <?= base64_decode($_GET['msg']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- First Name & Last Name -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">First Name</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="fname" id="fname" required /></div>
                    <div class="col-md-2"><label class="control-label">Last Name</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="lname" id="lname" required /></div>
                </div>

                <!-- Email & Password -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Email</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="email" class="form-control" name="email" id="email" required /></div>
                    <div class="col-md-2"><label class="control-label">Password</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="password" class="form-control" name="password" id="password" required /></div>
                </div>

                <!-- Date of Birth -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Date of Birth</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="date" class="form-control" name="dob" id="dob" required /></div>
                </div>

                <!-- NIC & Image -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">NIC</label><label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="nic" id="nic" required /></div>
                    <div class="col-md-2"><label class="control-label">Image</label></div>
                    <div class="col-md-4"><input type="file" class="form-control" name="user_image" id="user_image" onchange="displayImage(this);" /></div>
                </div>

                <!-- Contact No -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">Contact No</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4"><input type="text" class="form-control" name="cno1" id="cno1" required /></div>
                </div>

                <!-- User Role -->
                <div class="row mt-3">
                    <div class="col-md-2"><label class="control-label">User Role</label> <label class="text-danger">*</label></div>
                    <div class="col-md-4">
                        <select name="user_role" id="user_role" class="form-control" required>
                            <option value="">---Select User Role---</option>
                            <?php while ($roleRow = $roleResult->fetch_assoc()): ?>
                                <option value="<?= $roleRow['role_id']; ?>"><?= $roleRow['role_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <!-- Dynamic Functions Placeholder -->
                <div class="row mt-3">
                    <div id="display_functions" class="col-md-12"></div>
                </div>

                <!-- Submit / Reset Buttons -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <input type="reset" class="btn btn-danger" value="Reset" />
                    </div>
                </div>
        </div>
        </form>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../js/uservalidation.js"></script>
    <script>
        function displayImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    if (!document.getElementById('img_prev')) {
                        const img = document.createElement('img');
                        img.id = 'img_prev';
                        input.parentNode.appendChild(img);
                    }
                    document.getElementById('img_prev').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>