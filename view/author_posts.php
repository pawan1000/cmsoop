<?php
    include "includes/header.php";
    include "includes/navigation.php";
    include "../controller/authorposts_controller.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($_GET['author']))
            {
                echo Authorposts::getPosts($_GET['author']);
            }
            else
            {
                header("Location:index.php");
                exit();
            }
            ?>
        </div>
        <?php include "includes/sidebar.php";?>
    </div>
    <hr>
    <?php include "includes/footer.php";?>
     

