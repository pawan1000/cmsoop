<?php 
    include('C:\xampp\htdocs\cmsoop\admin\view\includes\admin_header.php');
    include('C:\xampp\htdocs\cmsoop\admin\view\includes\admin_navigation.php');
    include('C:\xampp\htdocs\cmsoop\admin\controller\profile_controller.php');
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <?php 
                echo Profile::getDetails();
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/admin_footer.php'; ?>
