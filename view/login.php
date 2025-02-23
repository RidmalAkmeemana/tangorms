<html lang="en">
<head>
    <?php include_once "../includes/bootstrap_css_includes.php" ?>
<link rel="stylesheet" type="text/css" href="../css/custom.css"/>
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
