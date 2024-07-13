
<?php
    include "includes/header.php";
    include "includes/navigation.php";
    include "../controller/post_controller.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($_GET['p_id']))
            {
                echo Post::getPosts($_GET['p_id']);
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
     
    <script>
        $(document).ready(function()
        {
            $("[data-toggle='tooltip']").tooltip();
            var post_id=<?php echo $_GET['p_id']; ?>;
            var user_id=<?php echo Functions::loggedin_userid(); ?>;
            //Like Post
            $('.like').click(function()
            {
                $.ajax(
                    {
                        url:"/cmsoop/view/post.php?p_id=<?php echo $_GET['p_id'];?>",
                        type:'post',
                        data:{
                                'liked':1,
                                'post_id':post_id,
                                'user_id':user_id
                            }
                    });
            });

            //Unlike Post
            $('.unlike').click(function()
            {
                $.ajax(
                    {
                        url:"/cmsoop/view/post.php?p_id=<?php echo $_GET['p_id'];?>",
                        type:'post',
                        data:{
                                'unliked':1,
                                'post_id':post_id,
                                'user_id':user_id
                             }
                    });
            });
        });
    </script>


