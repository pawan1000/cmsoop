<?php
include('C:\xampp\htdocs\cmsoop\admin\view\includes\admin_header.php');
include('C:\xampp\htdocs\cmsoop\admin\view\includes\admin_navigation.php');
include('C:\xampp\htdocs\cmsoop\admin\controller\categories_controller.php');
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <h1 class="page-header">
                    Welcome to Admin
                    <small><?php echo $_SESSION['username'];?></small>
                </h1>
                <?php echo Categories::addCategory();?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>