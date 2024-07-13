<?php
if (isset($_POST['postId']) && isset($_POST['status'])) {
    $postId = $_POST['postId'];
    $status = $_POST['status'];

    // Include your functions and database connection here
    require_once('C:\xampp\htdocs\cmsoop\view\functions.php');

    // Update the post status
    posts::updatePostStatus($postId, $status);
}
?>
