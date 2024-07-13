<?php error_reporting(1); ?>
<?php ob_start();?>
<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add these to your HTML file's head section -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CMS ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="/cmsoop/admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/cmsoop/admin/assets/css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="/cmsoop/admin/assets/font-awesome/css/font-awesome.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/cmsoop/admin/assets/js/functions.js"></script>

<script>
    $(document).ready(function(){
        $(".draft-btn").click(function(){
            var postId=$(this).data("post-id");
            $.ajax({
                url:'update_post_status.php',
                type:'POST',
                data:{postId:postId,status:'draft'},
                success:function(response)
                {
                    console.log(response);
                }
            });
        });
    });

</script>

    <style>
        @media (max-width: 768px) {
            /* Custom styles for smaller screens */
            .navbar-collapse {
                display: none;
            }
        }
    </style>
</head>
<body>