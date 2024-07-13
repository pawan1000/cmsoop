<?php  require_once('C:\xampp\htdocs\cmsoop\view\functions.php');?>
<?php session_start();?>
<?php
class posts
{
    public static function updatePostStatus($postId, $status)
    {
        global $conn;
        $query = "UPDATE posts SET post_status = '$status' WHERE post_id = '$postId'";
        $result = mysqli_query($conn, $query);

        // You can handle the result as needed, e.g., return a success/failure message
        if ($result) {
            echo 'Post status updated successfully!';
        } else {
            echo 'Failed to update post status!';
        }
    }


    public static function getSource()
    {
        if(isset($_GET['source']))
        {
            $source=$_GET['source'];
        }
        else
        {
            $source='';
        }
        switch($source)
        {
            case 'add_post':include "includes/add_post.php";break;
            case 'edit_post':include "includes/edit_post.php";break;
            default:include "includes/view_all_posts.php";
        }
        if (isset($_GET['source']) && isset($_GET['p_id']))
        {
            if($_GET['source']=='delete_post')
            {
                self::deletePost($_GET['p_id']);  
            }
        }
    }

    public static function deletePost($the_post_id)
    {
        global $conn;
        $query = "delete from posts where post_id='$the_post_id'";
        $result = mysqli_query($conn, $query);
        $query_delete_comment="delete from comments where comment_post_id='$the_post_id'";
        $result=mysqli_query($conn,$query_delete_comment);
        header("Location: posts.php");
    }

    public static function getPosts($start_date = 0, $end_date = 0)
    {
        global $conn;
        if (Functions::is_admin())
        {
            $query = "SELECT * FROM posts
                      INNER JOIN categories ON posts.post_category_id = categories.cat_id";
            
            if ($start_date != 0 && $end_date != 0)
            {
                $query .= " WHERE post_date BETWEEN '{$start_date}' AND '{$end_date}'";
            }
        } 
        else 
        {
            $user_id = Functions::loggedin_userid();
            $query = "SELECT * FROM posts
                      INNER JOIN categories ON posts.post_category_id = categories.cat_id
                      WHERE posts.user_id = '{$user_id}'";
            
            if ($start_date != 0 && $end_date != 0)
            {
                $query .= " AND post_date BETWEEN '{$start_date}' AND '{$end_date}'";
            }
        }
        
        $result = mysqli_query($conn, $query);
        return self::showPosts($result);
    }
    

    public static function showPosts($result)
    {
       //echo $_POST['start_date']; //yyyy-mm-dd
        global $conn;
        $posts= '<form action="/cmsoop/admin/view/posts.php" method="post"> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start date">Start Date</label>
                                <input type="date" required class="form-control" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="End date">End Date</label>
                                <input type="date" required class="form-control" name="end_date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="button"></label>
                                <input type="submit" class="btn btn-success form-control" name="submit" value="Apply">
                            </div>
                        </div>
                    </div>
                <table class="table table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Change Status</th>
                                <th>tag</th>
                                <th>Comments</th>
                                <th>Likes</th>
                                <th>Date</th>
                                <th>Post_Views_Count</th>
                                <th>View</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>';
                        if(mysqli_num_rows($result)>0)
                        {
                            while($row=mysqli_fetch_assoc($result))
                            {
                                $posts.= "<tr>
                                                <td>{$row['post_id']}</td>
                                                <td>{$row['post_author']}</td>
                                                <td>{$row['post_title']}</td>
                                                <td>{$row['cat_title']}</td>
                                                <td>{$row['post_status']}</td>
                                                <td><img width='100' src='/cmsoop/assets/images/{$row['post_image']}'></td>
                                                
                                                <td><button class='btn btn-primary draft-btn' data-post-id='{$row['post_id']}'>Draft</button></td>

                                                <td>{$row['post_tags']}</td>";

                                               // select * from posts where post_id<10 order by date desc limit 6,5;

                                                $comment_query="select count(comment_post_id) as comment_count
                                                                from comments
                                                                where comment_post_id={$row['post_id']} and comment_status='approve'
                                                                ";
                                                $comment_result=mysqli_query($conn,$comment_query);
                                                $post_comment_count=mysqli_fetch_assoc($comment_result);
                                                $comment_count=$post_comment_count['comment_count'];
                                                if(empty($comment_count))
                                                {
                                                    $comment_count=0;
                                                }

                                                $post_like_query="  select post_id,count(*) as likes_count
                                                                    from likes
                                                                    where post_id ={$row['post_id']}
                                                                    ";
                                                $post_like_result=mysqli_query($conn,$post_like_query);
                                                $post_likes=mysqli_fetch_assoc($post_like_result);
                                                $post_likes_count=$post_likes['likes_count'];
                                                if(empty($post_likes_count))
                                                {
                                                    $post_likes_count=0;
                                                }
                                                
                                        $posts.="<td><a href='/cmsoop/view/post.php?p_id={$row['post_id']}'>{$comment_count}</td>
                                                <td><a href='/cmsoop/view/post.php?p_id={$row['post_id']}'>{$post_likes_count}</td>
                                                <td>{$row['post_date']}</td>
                                                <td>{$row['post_views_count']}</td>
                                                <td><a class='btn btn-info' href='/cmsoop/view/post.php?p_id={$row['post_id']}'>View Post</a></td>
                                                <td><a onClick='return check_delete();' class='btn btn-danger' href='posts.php?source=delete_post&p_id={$row['post_id']}'>Delete</a></td>
                                                <td><a class='btn btn-primary' href='posts.php?source=edit_post&p_id={$row['post_id']}'>Edit</a></td>
                                        </tr>";
                            }
                        }
                        else
                        {
                            $posts.= "<tr>
                                        <td colspan='13' style='text-align: center;'><h1>No Records Found</h1></td>
                                      </tr>";
                        }   
                $posts.= "</tbody>
                          </table>
                          </form>";

        return $posts;
    }
    public static function addPost()
    {
        global $conn;
        if(isset($_POST['create_post']))
        {
        $user_id=Functions::escape($_POST['user_id']);
        $post_title=Functions::escape($_POST['title']);
        $post_author=Functions::escape($_POST['author']);
        $post_status=Functions::escape($_POST['post_status']);
        $post_category_id=Functions::escape($_POST['post_category']);
        $post_tags=Functions::escape($_POST['post_tags']);
        $post_content=Functions::escape($_POST['post_content']);
        $post_date=Functions::escape(date('d-m-y'));
        $post_image=Functions::escape($_FILES['image']['name']);
        $post_image_temp=$_FILES['image']['tmp_name'];
        $target_directory = 'C:\\xampp\\htdocs\\cmsoop\\assets\\images\\'; // Note the double backslashes for Windows paths
        $target_file = $target_directory . basename($post_image);
        if (move_uploaded_file($post_image_temp, $target_file)) {
            echo "File is valid, and was successfully uploaded.\n";
        } else {
            echo "File upload failed.\n";
        }
        
        $emptyfields=array();
        if (empty($post_title))
        {
            $emptyfields[] = "Post Title";
        }
        if (empty($post_content))
        {
            $emptyfields[] = "Post Content";
        }
        if ($post_category_id==0)
        {
            $emptyfields[] = "Post Category";
        }
        // if ($post_status==0)
        // {
        //     $emptyfields[] = "Post Status";
        // }
        if(empty($post_image))
        {
            $emptyfields[] = "Post Image";
        }
        if(sizeof($emptyfields)>0)
        {
            echo "This fields Should not be empty ";
            echo "<br>";
            foreach ($emptyfields as $field)
                echo $field."<br>";
        }
        else
        {
            $query="INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags,post_status,user_id) VALUES ('$post_category_id','$post_title','$post_author',now(),'$post_image','$post_content','$post_tags','$post_status','$user_id')";
            $result=mysqli_query($conn,$query);
            $the_post_id=mysqli_insert_id($conn);//gives last genrated post id
            echo "<p class='bg-success'>Post Created. <a href='/cmsoop/view/post.php?p_id=$the_post_id'>View Post </a></p>";
        }
    }
    

    return self::showForm($post_title, $post_tags, $post_content,$post_category_id,$post_status);
    }
    public static function showForm($post_title, $post_tags, $post_content,$post_category_id,$post_status)
    {
        global $conn;
        $form= '<form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text"  class="form-control" name="title" value="'.$post_title.'">
                </div>
                <!-- select categories  -->
                <div class="form-group">
                <label for="title">Post Category</label>
                <br>
                <select name="post_category" id="">
                    <option value="0">Select Category</option>';
                        $query="select * from categories";
                        $result=mysqli_query($conn,$query);
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $cat_id=$row['cat_id'];
                            $cat_title=$row['cat_title'];
                            $selected = ($cat_id == $post_category_id) ? 'selected' : '';
                            $form.= "<option value='$cat_id' $selected>{$cat_title}</option>";
                        }
        $form.= '</select>
                </div>
                <div class="form-group">
                    <label for="title">Post Status</label>
                    <select name="post_status" id="">
                        <option value="0">select option</option>
                        <option value="draft" ' . ($post_status === 'draft' ? 'selected' : '') . '>draft</option>
                    <option value="published" ' . ($post_status === 'published' ? 'selected' : '') . '>published</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Post Image</label>
                    <input type="file"  class="form-control" name="image" >
                </div>
                <div class="form-group">
                    <input type="hidden"  class="form-control" name="hidden_image" >
                </div>
                <div class="form-group">
                    <label for="title">Post Tag</label>
                    <input type="text"  class="form-control" name="post_tags" value="'.$post_tags.'">
                </div>
                <div class="form-group">
                    <label for="title">Post Content</label>
                    <textarea class="form-control"  id="summernote" name="post_content" cols="30" rows="10">'.$post_content.'</textarea>   
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="create_post" value="publish Post">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" readonly value="'. Functions::get_fullname().'" name="author">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" readonly value="'.Functions::loggedin_userid().'" name="user_id">
                </div>        
        </form>';
    return $form;
    }


    public static function getDetails($the_post_id)
    {
        global $conn;
        $query="select * from posts where post_id='$the_post_id'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)<=0)
        {
            echo "<h1>Sorry No Such Post Exists!!!</h1>";
            exit();
        }
        else
        {
            // echo "getDetails called";
            return self::showPost($result,$the_post_id);
        }
    }
    
    public static function showPost($result,$the_post_id)
    {
        // echo "showPost called";
        global $conn;
        self::editPost($the_post_id);
        $row=mysqli_fetch_assoc($result);
        $post_title=$row['post_title'];
        $post_author=$row['post_author'];
        $post_status=$row['post_status'];
        $post_category_id=$row['post_category_id'];
        $post_tags=$row['post_tags'];
        $post_content=$row['post_content'];
        $post_date=$row['post_date'];
        $post_comment_count=$row['post_comment_count'];
        $post_image=$row['post_image'];
        $post_image_old=$row['post_image'];

        $post= '<form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" required value="'.$post_title.'" class="form-control" name="title" >
                </div>
                <div class="form-group">
                    <label for="title">Category</label>
                    <select name="post_category_id" class="form-control">';
                        
                            $query = "SELECT * FROM categories";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                if($cat_id == $post_category_id)
                                {
                                    $post.= "<option selected value='{$cat_id}'>{$cat_title}</option>";
                                }
                                else
                                {
                                    $post.= "<option value='{$cat_id}'>{$cat_title}</option>";
                                }
                            }
                    
         $post.='       </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Post Author</label>
                            <input type="text" required value="'.$post_author.'" class="form-control" name="author" >
                        </div>
                        <div class="form-group">
                            <label for="title">Post Status</label>
                            <select name="post_status" class="form-control">';
                                
                                    if($post_status=='draft')
                                    {
                                        $post.='<option value="draft">draft</option>';
                                        $post.='<option value="published">published</option>';
                                    }
                                    else
                                    {
                                        $post.='<option value="published">published</option>';
                                        $post.='<option value="draft">draft</option>';
                                    }
                                
                            $post.='</select>
                        </div>
                        <div class="form-group">
                            <label for="title">Post Image</label>
                            <img src="/cmsoop/assets/images/'.$post_image.'" alt="image" width="100">
                            <input type="file" class="form-control" name="image" >
                        </div>
                        <div class="form-group">
                            <label for="title">Post Tag</label>
                            <input type="text" required value="'.$post_tags.'" class="form-control" name="post_tags" >
                        </div>
                        <div class="form-group">
                            <label for="title">Post Content</label>
                            <textarea class="form-control" required  name="post_content" cols="50" rows="10" >'.$post_content.'</textarea>   
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="update_post" value="update Post">
                        </div>
    </form>';
    return $post;
    }

    public static function editPost($the_post_id)
    {
        global $conn;
        if (isset($_POST['update_post']))
        {
            $post_category_id=$_POST['post_category_id'];
            $post_title=$_POST['title'];
            $post_author=$_POST['author'];
            $post_status=$_POST['post_status'];
            $post_tags=$_POST['post_tags'];
            $post_content=$_POST['post_content'];
            $post_image=$_FILES['image']['name'];
            $post_image_temp=$_FILES['image']['tmp_name'];
            move_uploaded_file($post_image_temp,"../images/$post_image");
            if(empty($post_image))
            {
                $query="select * from posts where post_id='$the_post_id'";
                $result=mysqli_query($conn,$query);
                while($row=mysqli_fetch_assoc($result))
                {
                    $post_image=$row['post_image'];
                }
            }
            $emptyfields=array();
            if (empty($post_title))
            {
                $emptyfields[] = "Post Title";
            }
            if (empty($post_content))
            {
                $emptyfields[] = "Post Content";
            }
            if ($post_category_id==0)
            {
                $emptyfields[] = "Post Category";
            }
            if(empty($post_image))
            {
                $emptyfields[] = "Post Image";
            }
            if(sizeof($emptyfields)>0)
            {
                echo "This fields Should not be empty ";
                echo "<br>";
                foreach ($emptyfields as $field)
                    echo $field."<br>";
            }
            else 
            {
                $query = "UPDATE posts SET
                post_title = '$post_title',
                post_date = NOW(),
                post_author = '$post_author',
                post_status = '$post_status',
                post_tags = '$post_tags',
                post_content = '$post_content',
                post_image = '$post_image',
                post_category_id = '$post_category_id' 
                WHERE post_id = '$the_post_id'";
                $result=mysqli_query($conn,$query);
                Functions::redirect("posts.php");
            }
        }
    }
}

?>


