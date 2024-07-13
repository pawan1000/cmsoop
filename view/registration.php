<?php
    include "includes/header.php";
    include "includes/navigation.php";
?>

<!-- Page Content -->
<div class="container"> 
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>REGISTER</h1>
                        <form role="form" action="../controller/register_controller.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" minlength="6" required autocomplete="off" name="username" id="username" class="form-control" placeholder="Enter Your Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" required id="email" class="form-control" placeholder="Enter Your Email">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" minlength="6" required name="password" id="key" class="form-control" placeholder="Enter Your Password">
                            </div>
                            <input type="submit" name="Register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
<hr>

<?php include "includes/footer.php";?>
