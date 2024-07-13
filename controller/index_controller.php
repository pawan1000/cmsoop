<?php 
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');
?>
<?php
class Home extends Functions
{
    public static function getPosts()
    {
       global $conn;
       
        if(isset($_GET['page']))
        {
            $page=$_GET['page'];
        }
        else
        {
            $page="";
        }
        if($page==""||$page==1)
        {
            $page_1=0; //variable name
        }
        else
        {
            $page_1=($page*5)-5;
        }

        $query="select * from posts where post_status='published' limit $page_1,5";
        $result=mysqli_query($conn,$query);
        $posts="";
        if(mysqli_num_rows($result)<1 )
        {
            $posts.= "No Posts";
        } 
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $posts.= self::showPosts($row);
            }
        }
    return $posts;
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
    public static function showPageNo()
    {
        $pageno='<ul class="pager">';
        $count=ceil(self::get_postscount('dashboard')/5);
        for($i=1;$i<=$count;$i++)
        {
            $pageno.="<li><a href='index.php?page=$i'>{$i}</a></li>";
        }
        $pageno.='</ul>';

    return $pageno;
    }
}



?>