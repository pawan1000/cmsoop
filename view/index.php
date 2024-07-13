<?php
    include "includes/header.php";
    include "includes/navigation.php";
    include "../controller/index_controller.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            echo Home::getPosts();
            ?>
        </div>
        <?php include "includes/sidebar.php";?>
    </div>
    <hr>
     <?php include "includes/footer.php";?>
     <?php echo Home::showPageNo();?>
