<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" required name ="search" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div><!-- /.input-group -->
        </form><!-- search form -->
    </div>

    <div class="well">
    <!-- Login Form  Well -->
        <?php if (isset($_SESSION['logged_in'])): ?>
            <h1>Logged in as <?php echo $_SESSION['username']; ?></h1>
            <form method="post" action="../controller/login_controller.php">
                <button class="btn btn-primary" name="Logout" type="submit">Log Out</button>
            </form>
        <?php else: ?>
            <h4>Login Here</h4>
            <form action="../controller/login_controller.php" method="post">
                <div class="form-group">
                    <input type="text" required name ="username" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input type="password" required name ="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="Login" type="submit">Login</button>
                    </span>
                </div>
                <div class="form-group">
                <a href="forgot.php">Forgot Password</a>
                </div>
            </form>
        <?php endif ?>
    </div>

    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                    <ul class="list-unstyled">
                        <?php echo Functions::getCategories(); ?>
                    </ul>
            </div>
        </div>
    </div>

    <?php include 'widget.php';?>
</div>