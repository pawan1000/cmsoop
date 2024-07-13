<?php 
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');
?>
<?php
class Post extends Functions
{
    public static function getPosts($p_id)
    {
        global $conn;
        $query = "select * from posts where post_id='$p_id'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)<1 )
        {
            return "<h1>No Posts Available </h1>";
        } 
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                return self::showPosts($row);
            }
        }
        
    }

    public static function postLikes()
    {
        global $conn;
        if(isset($_POST['liked']))
        {
            // echo "like code";
            $post_id=$_POST['post_id'];
            $user_id=$_POST['user_id'];
            // selecting the specific post
            $query="select * from posts where post_id=$post_id";
            $result=mysqli_query($conn,$query);
            $row=mysqli_fetch_assoc($result);
            $likes=$row['likes']; // fetching the likes available to that post
            $query="update posts set likes=$likes+1 where post_id=$post_id";
            $result=mysqli_query($conn,$query);
            $query="insert into likes(user_id,post_id) values($user_id,$post_id)";
            $result=mysqli_query($conn,$query);
            exit();
        }

        if(isset($_POST['unliked']))
        {
            // echo "unliked code";
            $post_id=$_POST['post_id'];
            $user_id=$_POST['user_id'];
            $query="select * from posts where post_id=$post_id";
            $result=mysqli_query($conn,$query);
            $row=mysqli_fetch_assoc($result);
            $likes=$row['likes'];
            $query="delete from likes where post_id=$post_id and user_id=$user_id";
            $result=mysqli_query($conn,$query);
            $query="update posts set likes=$likes-1 where post_id=$post_id";
            $result=mysqli_query($conn,$query);
            exit();
        }

    }
    public static function showPosts($row)
    {
        self::postLikes();
        self::addComment();
        global $conn;
        $post_title=$row['post_title'];
        $post_id=$row['post_id'];
        $post_author=$row['post_author'];
        $post_date=$row['post_date'];
        $post_image=$row['post_image'];
        $post_content=$row['post_content'];

        $post='<h2><a href="post.php?p_id='.$post_id.'">' . $post_title . '</a></h2>'. 
                '<p class="lead">by <a href="/cmsoop/view/author_posts.php?author='.$post_author.'">' . $post_author . '</a></p>'.
                '<p><span class="glyphicon glyphicon-time"></span> ' . $post_date . '</p>'. 
                '<hr>'. 
                '<a href="post.php?p_id='.$post_id.'"><img class="img-responsive" height="300" width="300" src="/cmsoop/assets/images/' . $post_image . '" alt=""></a>'. 
                '<hr>'. 
                '<p>' . $post_content . '</p>';
                if(Functions::isLoggedIn())
                {
                    $post.='<div class="row">
                                <p class="pull-right">
                                    <a href="" class="'.(Functions::user_likedthis_post($post_id)? 'unlike':'like').'">
                                        <span class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" title="'.(Functions::user_likedthis_post($post_id)? 'I liked this post before' : 'Want to Like this post').'"></span>
                                        '.(Functions::user_likedthis_post($post_id)? 'unlike':'like').'
                                    </a>
                                </p>
                            </div>';  
                }
                else
                {
                    $post.='<div class="row">
                                <p class="pull-right">You Need to Login to like the post !!!</p>
                            </div>';
                }
                
        $post.=        '<div class="row">
                            <p class="pull-right">Likes :'.Functions::getpostlikes($post_id).'</p>
                        </div>
                        <hr>';

        $post.= '<div class="well">'.
                '<h4>Leave a Comment:</h4>'.
                '<form action="" method="post" role="form">'.
                '<div class="form-group">'.
                '<label for="Author">Author</label>'.
                '<input type="text" readonly class="form-control" name="comment_author" value="' . (self::isLoggedIn() ? self::get_fullname() : '') . '">'.
                '</div>'.
                '<div class="form-group">'.
                '<label for="Email">Email</label>'.
                '<input type="text" class="form-control" name="comment_email" value="' . (self::isLoggedIn() ? self::get_emailid() : '') . '">'.
                '</div>'.
                '<div class="form-group">'.
                '<label for="Comment">Comment</label>'.
                '<textarea class="form-control" name="comment_content" rows="3" required></textarea>'.
                '</div>'.
                '<input type="submit" name="create_comment" value="submit" ' . (!self::isLoggedIn() ? 'disabled' : '') . '>'.
                '</form>'.
                '</div>'.
                '<hr>';

               $query="select * from comments where comment_post_id= '$post_id' and comment_status='approve' order by comment_id desc";
               $result=mysqli_query($conn,$query);
               while($row=mysqli_fetch_assoc($result))
               {
                   $comment_date=$row['comment_date'];
                   $comment_content=$row['comment_content'];
                   $comment_author=$row['comment_author'];
                   $post.=  '<div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object" src="/cmsoop/assets/images/comment.jpg" alt="" width="80">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">' . $comment_author . '
                                        <small>' . $comment_date . '</small>
                                    </h4>' .
                                    $comment_content . '
                                </div>
                            </div>';
               }
       
    return $post;
    }

    public static function addComment()
    {
        global $conn;
        if(isset($_POST['create_comment']))
        {
            $the_post_id=self::escape($_GET['p_id']);
            $comment_author=self::escape($_POST['comment_author']);
            $comment_email=self::escape($_POST['comment_email']);
            $comment_content=self::escape($_POST['comment_content']);
            if(!empty($comment_author)&& !empty($comment_email)&& !empty($comment_content))
            {
                $query="insert into comments(comment_post_id,comment_author,comment_content,comment_email,comment_status,comment_date) values ('$the_post_id','$comment_author','$comment_content','$comment_email','unapproved',now())";
                $result=mysqli_query($conn,$query);
                $query="update posts set post_comment_count=post_comment_count+1 where  post_id=$the_post_id";
                $update_comment_count=mysqli_query($conn,$query);
            }
            else
            {
                echo "<script>alert('fields should not be empty');</script>";
            }
        }
    }

}
?>