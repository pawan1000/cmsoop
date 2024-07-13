<?php 
    require_once('C:\xampp\htdocs\cmsoop\admin\controller\posts_controller.php');
    if(isset($_POST['submit']))
    {
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];
        echo posts::getPosts($start_date,$end_date);
    }
    else
    {
        echo posts::getPosts();
    }

?>