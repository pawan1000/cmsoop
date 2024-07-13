<?php 
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');

?>
<?php
class Search extends Functions
{
    public static function getPosts($search)
    {
        global $conn;
        $post="";
        $query="select * from posts where post_tags like '%$search%' or post_title like '%$search%' or post_author like '%$search%' ";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)<1 )
        {
            $post= "<h1>No Posts Available for this Search<h1>";
        } 
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $post.= self::showPosts($row);
            }
        }
        return $post;
        
    }
    public static function showPosts($row)
    {
        $post_title=$row['post_title'];
        $post_id=$row['post_id'];
        $post_author=$row['post_author'];
        $post_date=$row['post_date'];
        $post_image=$row['post_image'];
        $post_content=substr($row['post_content'],0,100);

        $post='<h2><a href="post.php?p_id='.$post_id.'">' . $post_title . '</a></h2>'. 
                '<p class="lead">by <a href="/cmsoop/view/author_posts.php?author='.$post_author.'">' . $post_author . '</a></p>'.
                '<p><span class="glyphicon glyphicon-time"></span> ' . $post_date . '</p>'. 
                '<hr>'. 
                '<a href="post.php?p_id='.$post_id.'"><img class="img-responsive" height="300" width="300" src="/cmsoop/assets/images/' . $post_image . '" alt=""></a>'. 
                '<hr>'. 
                '<p>' . $post_content . '</p>'.
                '<a class="btn btn-primary" href="post.php?p_id='.$post_id.'">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>'. 
                '<hr>';        
    return $post;
    }
}
?>