<div class="row" style="height:50px">

</div>
<div class="row" style="height:150px">
    <div class="col-md-3">
        <img src="../images/logo1.png" width="150px" heigth="150px"/>
    </div>
    <div class="col-md-6" style="text-align: center">
        <h1>Tango Restaurant Management System</h1>
    </div>
    <div class="col-md-3">
        &nbsp;
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-3">
        <?php
            echo ucwords($userrow["user_fname"]." ".$userrow["user_lname"]);
        ?>
    </div>
    <div class="col-md-6" style="text-align: center">
        <h4>Tango Restaurant Management System</h4>
    </div>
    <div class="col-md-1 col-md-offset-2">
        <a href="../controller/login_controller.php?status=logout" class="btn btn-primary">Logout</a>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h5 align="center">
            <?php echo $pageName; ?>
        </h5>
    </div>
</div>