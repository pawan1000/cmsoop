<?php
    include "includes/header.php";
    include "includes/navigation.php";
    include "../controller/category_controller.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($_GET['category']))
            {
                echo Category::getPosts($_GET['category']);
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
     

