<?php
include('C:\xampp\htdocs\cmsoop\admin\controller\adminnavigation_controller.php');
Functions::check_ifuserisloggedin_and_redirect('/cmsoop/view/index.php');
?>

<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" style="position: fixed; left: 0;" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Admin</a>
        </div>
            <?php 
                echo AdminNavigation::showTopNavbar();
                echo AdminNavigation::showSideNavbar();
            ?>
       </div>
    </nav> 

