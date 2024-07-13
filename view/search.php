<?php
    include "includes/header.php";
    include "includes/navigation.php";
    include "../controller/search_controller.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($_POST['submit'])) 
            {
                echo Search::getPosts($_POST['search']);
            }
            ?>
        </div>
        <?php include "includes/sidebar.php";?>
    </div>
    <hr>
    <?php include "includes/footer.php";?>
     

