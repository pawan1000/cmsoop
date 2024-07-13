<?php 
    require_once('C:\xampp\htdocs\cmsoop\admin\controller\users_controller.php');
    echo Users::getDetails($_GET['edit_user']);
?>