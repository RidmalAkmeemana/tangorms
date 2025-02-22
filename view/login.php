<html lang="en">
<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
    <style>
        /* Custom Theme Colors */
        body {
            background-color: black; /* Black background */
            color: white; /* White text */
        }

        .panel-default {
            border: 1px solid #FF6600; /* Orange border for panel */
            background-color: #333; /* Dark background for the panel */
        }

        .panel-default .panel-heading {
            background-color: #FF6600; /* Orange background for panel heading */
            color: white;
        }

        .input-group-addon {
            background-color: #FF6600; /* Orange background for input group add-ons */
            color: white;
        }

        .form-control {
            background-color: #555; /* Dark background for inputs */
            color: white;
            border: 1px solid #FF6600; /* Orange border for form inputs */
        }

        .form-control:focus {
            border-color: #FF6600; /* Orange border on focus */
            background-color: #333; /* Dark background when focused */
        }

        .btn-primary {
            background-color: #FF6600; /* Orange background for the button */
            border-color: #FF6600;
        }

        .btn-primary:hover {
            background-color: #e65c00; /* Slightly darker orange on hover */
            border-color: #e65c00;
        }

        .alert-danger {
            background-color: #cc3300; /* Red background for error messages */
            color: white;
        }

        .input-group {
            margin-bottom: 15px;
        }

        h3 {
            font-size: 24px;
            color: white;
        }

        .forgot-password {
            color: #FF6600;
            font-size: 14px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Center the login form vertically on the page */
        .row {
            margin-top: 20px;
        }

        /* Adjust the logo container */
        .logo-container {
            display: flex;
            justify-content: center; /* Centers the logo horizontally */
            margin-bottom: 30px; /* Space between the logo and form */
        }

        .logo-container img {
            max-width: 100%;
            height: auto;
            max-height: 250px; /* You can adjust this height as needed */
        }

        /* Login form styles */
        .login-form {
            width: 100%;
        }

        .login-form .input-group {
            margin-bottom: 20px; /* Increased margin for better spacing */
        }

        .login-form .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Space for header or any additional content -->
        <div class="row" style="height:100px"></div>

        <form action="../controller/login_controller.php?status=login" method="post">
            <!-- Error Message Handling -->
            <div class="row">
                <div id="msg" class="col-md-6 col-md-offset-3">
                </div>
                <?php if (isset($_GET["msg"])) { ?>
                    <div class="col-md-6 col-md-offset-3 alert alert-danger">
                        <?php echo base64_decode($_GET["msg"]); ?>
                    </div>
                <?php } ?>
            </div>
            
            <!-- Login Panel -->
            <div class="row">
                
                <div class="col-md-8 col-md-offset-2 panel panel-default">

                <div class="row" style="margin-top: 20px;">
                </div>
                    <!-- Logo Image -->
                    <div class="logo-container">
                        <img src="../images/logo1.png" alt="Logo" class="img-responsive"/>
                    </div>

                    <!-- Login Form Section -->
                    <div class="login-form">
                        <div class="row">
                            <h3 class="text-center" style="margin-top: 10px;">Sign In to Your Account</h3>
                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <!-- Username Input -->
                            <div class="col-md-8 col-md-offset-2" >
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <input type="email" id="loginusername" name="loginusername" class="form-control" placeholder="Enter your email" required />
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 15px;">
                            <!-- Password Input -->
                            <div class="col-md-8 col-md-offset-2">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </div>
                                    <input type="password" id="loginpassword" name="loginpassword" class="form-control" placeholder="Enter your password" required />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-8 col-md-offset-2">
                                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login" />
                            </div>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12 text-center">
                                <a href="#" class="forgot-password">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript Includes -->
    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../js/loginValidation.js"></script>
</body>
</html>
