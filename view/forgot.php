<?php
    include "includes/header.php";
    include "includes/navigation.php";
?>
<!-- Page Content -->
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
                                <p>Plz enter your email here</p>
                                <div class="panel-body">
                                    <form id="register-form" action="../controller/forgot_controller.php" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Submit" type="submit">
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
        <?php include "includes/footer.php"; ?>
    </div>