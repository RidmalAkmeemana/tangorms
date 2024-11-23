<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css"/>
    </head>
    <body>
        <div class="container">
            <div class="row" style="height:100px">
            </div>
            <form action="../controller/login_controller.php?status=login" method="post">
                <div class="row">
                    <div id="msg" class="col-md-6 col-md-offset-3">
                    </div>
                    <?php
                        if(isset($_GET["msg"])){
                    ?>
                    <div  class="col-md-6 col-md-offset-3 alert alert-danger">
                        <?php
                            echo base64_decode($_GET["msg"]);
                        ?>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 panel panel-default" style="height:300px">
                        <div class="col-md-6" style="height:300px">
                            <img src="../images/logo.png" height="300px"/>
                        </div>
                        <div class="col-md-6" style="height:300px">
                            <div class="row">
                                &nbsp;
                            </div>
                            <div class="row">
                                <label style="font-size:18px">Sign Into Your Account</label>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"></span>
                                        </span>
                                        <input type="email" id="loginusername" name="loginusername" class="form-control" />
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                &nbsp;
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span>
                                        </span>
                                        <input type="password" id="loginpassword" name="loginpassword" class="form-control" />
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                &nbsp;
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="submit" class="btn btn-primary btn-block" style="background-color:#170680"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script src="../js/jquery-3.7.1.js"></script>
    <!-- <script src="../js/loginValidation.js"></script> -->
</html>