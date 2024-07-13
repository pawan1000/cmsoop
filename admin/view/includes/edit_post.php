<?php 
    require_once('C:\xampp\htdocs\cmsoop\admin\controller\posts_controller.php');
    echo Posts::getDetails($_GET['p_id']);
?>