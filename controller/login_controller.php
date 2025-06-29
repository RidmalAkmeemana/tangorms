<?php
include '../commons/session.php';

if (!isset($_GET["status"])) {
    ?>
    <script>
        window.location = "../view/login.php";
    </script>
    <?php
    exit();
}

$status = $_GET["status"];

include_once '../model/login_model.php';
$loginObj = new Login();

switch ($status) {
    case "login":
        $login_username = $_POST["loginusername"];
        $login_password = $_POST["loginpassword"];

        try {
            if (empty($login_username)) {
                throw new Exception("User Email cannot be empty");
            }
            if (empty($login_password)) {
                throw new Exception("Password cannot be empty");
            }

            $loginResult = $loginObj->validateUser($login_username, $login_password);

            if ($loginResult->num_rows > 0) {
                $userrow = $loginResult->fetch_assoc();

                // Start the session and store user details
                $_SESSION["user"] = $userrow;

                ?>
                <script>
                    window.location = "../view/dashboard.php";
                </script>
                <?php
            } else {
                throw new Exception("Invalid Email or Password or your account may be inactive");
            }

        } catch (Exception $ex) {
            $msg = base64_encode($ex->getMessage());
            ?>
            <script>
                window.location = "../view/login.php?msg=<?php echo $msg ?>";
            </script>
            <?php
        }
        break;

    case "logout":
        session_destroy();
        ?>
        <script>
            window.location = "../view/login.php";
        </script>
        <?php
        break;
}
