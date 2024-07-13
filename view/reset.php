<?php
    include "includes/header.php";
    include "includes/navigation.php";
?>
<?php 
if(!isset($_SESSION['reset_email']))
{
    echo '<script>alert("Pls Enter the registerd email first"); window.location.href = "/cmsoop/view/index.php";</script>';
}
?>
<div class="container">
    <div class="form-gap"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form" action="../controller/reset_controller.php" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="username" name="username" placeholder="Enter Your Username" class="form-control"  type="username" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Enter New Password" class="form-control"  type="Password" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="reset" class="btn btn-lg btn-primary btn-block" value="Reset" type="submit">
                                        </div>
                                    </form>
                                </div><!-- Body-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php include "includes/footer.php";?>
    </div>