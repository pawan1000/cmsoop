<?php

use PhpParser\Node\Expr\FuncCall;

include 'C:\xampp\htdocs\cmsoop\view\includes\connection.php';
class Functions 
{
    
    public static function escape($string)
    {
        global $conn;
        return mysqli_real_escape_string($conn,trim($string));
    }

    public static function username_exists($username='')
    {
        global $conn;
        $query="select username from users where username='$username'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function email_exists($email='')
    {
       global $conn;
        $query="select user_email from users where user_email='$email'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function redirect($location)
    {
        header("Location:" .$location);
        exit;
    }

    public static function isLoggedIn()
    {
        if (isset($_SESSION['user_role']))
        {
            return True;
        }
        return false;
    }

    public static function check_ifuserisloggedin_and_redirect($redirectlocation=null)
    {
        if(!self::isLoggedIn())
        {
            self::redirect($redirectlocation);
        }
    }

    public static function loggedin_userid()
    {
        global $conn;
        if(self::isLoggedIn())
        {
            $username=$_SESSION['username'];
            $query="select * from users where username='$username'";
            $result=mysqli_query($conn,$query);
            $row=mysqli_fetch_assoc($result);
            return mysqli_num_rows($result)>=1?$row['user_id']:false;
        }
        return false;
    }

    public static  function is_admin()
    {
        global $conn;
        $username=$_SESSION['username'];
        $query="select * from users where username='$username'";
        $result=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($result);
        if($row['user_role']=='Admin')
        {
            return true;
        }
        return false;
    }


    public static function get_username()
    {
        return isset($_SESSION['username'])?$_SESSION['username']:null;
    }

    public static function get_fullname()
    {
        return $_SESSION['user_firstname']." ".$_SESSION['user_lastname'];
    }
    public static function get_emailid()
    {
        global $conn;
        $username=$_SESSION['username'];
        $query="select * from users where username='$username'";
        $result=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($result);
        return $row['user_email'];
    }
    public static function user_likedthis_post($post_id='')
    {
        global $conn;
        $user_id=self::loggedin_userid();
        $query="select * from likes where user_id='$user_id' and post_id='$post_id'";
        $result=mysqli_query($conn,$query);
        return mysqli_num_rows($result)>=1?true:false;
    }

    public static function getpostlikes($post_id)
    {
        global $conn;
        $query="select * from likes where post_id='$post_id'";
        $result=mysqli_query($conn,$query);
        return mysqli_num_rows($result);
    }
    

    public static function get_postscount($pagename)
    {
        global $conn;
        $user_id=self::loggedin_userid(); //54
        $query="select * from posts ";
        if($pagename=="my_data")
        {
            $query.= "where user_id='$user_id'";
        }
        if(isset($_POST['submit']))
        {
            $start_date=$_POST['start_date'];
            $end_date=$_POST['end_date'];
            if($pagename=="my_data")
            {
                $query.= "AND";
            }
            else
            {
                $query.= "where";   
            }
            $query .= " post_date BETWEEN '{$start_date}' AND '{$end_date}'";
        }
        //echo $query;exit();
        $result=mysqli_query($conn,$query);
        return mysqli_num_rows($result);
    }

    public static function get_commentscount($pagename)
    {
        global $conn;
        $user_id=self::loggedin_userid();
        $query="select * from comments inner join posts on posts.post_id=comments.comment_post_id
                where  ".($pagename=="my_data"?" user_id='$user_id'":"true");
        if(isset($_POST['submit']))
        {
            $start_date=$_POST['start_date'];
            $end_date=$_POST['end_date'];
            $query .= " AND post_date BETWEEN '{$start_date}' AND '{$end_date}'";
        }
        $result=mysqli_query($conn,$query);
        return mysqli_num_rows($result);
    }
    

    public static function get_categoriescount($pagename)
    {   global $conn;
        $user_id=54;
        $query="select distinct ".($pagename=="my_data"?"post_category_id":"cat_id"). " from ".($pagename=="my_data"?"posts":"categories")." where ".($pagename=="my_data"?"user_id='$user_id'":"true");
        $result=mysqli_query($conn,$query);
        return mysqli_num_rows($result);
        // $query="select distinct post_category_id from posts where user_id='$user_id'";
        // $query="select * from categories";
    }
    public static function get_userscount()
    {   global $conn;
        $query="select * from users";
        $result=mysqli_query($conn,$query);
        return mysqli_num_rows($result);
    }
    public static function get_userrole()
    {global $conn;
        $user_id=self::loggedin_userid();
        $query="select * from users where user_id=$user_id";
        $result=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($result);
        return $row['user_role'];
    }
    
    public static function add_category($cat_title)
    {global $conn;
        if ($cat_title == "" || empty($cat_title)) 
        {
            echo "this field should not be empty";
        } 
        else
        {
            $query = "insert into categories(cat_title) value ('$cat_title')";
            $result = mysqli_query($conn, $query);
            if (!$result)
            {
                die("query failed" . mysqli_error($conn));
            }
        }
    }

    public static function update_category($the_cat_title,$cat_id)
    {
        global $conn;
        $query = "update categories SET cat_title='$the_cat_title' where cat_id='$cat_id' ";
        $result = mysqli_query($conn, $query);
        self::redirect('categories.php');
    }

public static function delete_category($the_cat_id)
{global $conn;
    $query = "delete from categories where cat_id={$the_cat_id}";
    $result = mysqli_query($conn, $query);
    header("Location:categories.php");
}

public static function delete_comment($the_comment_id)
{global $conn;
    $query="delete from comments where comment_id='$the_comment_id'";
    $result=mysqli_query($conn,$query);
    header("Location:comments.php");
}

public static function reject_comment($the_comment_id)
{global $conn;
    $query="update comments set comment_status = 'reject' where comment_id='$the_comment_id'";
    $result=mysqli_query($conn,$query);
    header("Location:comments.php");
}

public static function approve_comment($the_comment_id)
{global $conn;
    $query="update comments set comment_status = 'approve' where comment_id='$the_comment_id'";
    $result=mysqli_query($conn,$query);
    header("Location:comments.php");
}

public static function show_users()
{global $conn;
    $query="select * from users";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0)
    {    
        $rows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach($rows as $row) 
        {
            $user_id=$row['user_id'];
            echo"<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['user_firstname']}</td>
                <td>{$row['user_lastname']}</td>
                <td>{$row['user_email']}</td>
                <td>{$row['user_role']}</td>
                <td><a class='btn btn-info'    href='users.php?change_to_admin=$user_id'>Admin</a></td>
                <td><a class='btn btn-success' href='users.php?change_to_subscriber=$user_id'>Subscriber</a></td>
                <td><a class='btn btn-primary' href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>
                <td><a class='btn btn-danger'  onClick='return check_delete();' href='users.php?delete= $user_id'>Delete</a></td>
            </tr>";
        }
    }
    else
    {
        echo "<tr>
        <td colspan='10'style='text-align: center;'><h1>No Records Found</h1></td>
        </tr>";
    }
}

public static function delete_user($the_user_id)
{global $conn;
    $query="delete from users where user_id='$the_user_id'";
    $result=mysqli_query($conn,$query);
    header("Location:users.php");
}

public static function change_to_admin($the_user_id)
{global $conn;
    $query="update users set user_role = 'Admin' where user_id='$the_user_id'";
    $result=mysqli_query($conn,$query);
    if($the_user_id==self::loggedin_userid())
    {
    $_SESSION['user_role']='Admin';
    }
    header("Location:users.php");
}

public static function change_to_subscriber($the_user_id)
{
    global $conn;
    $query="update users set user_role = 'Subscriber' where user_id='$the_user_id'";
    $result=mysqli_query($conn,$query);
    if($the_user_id==self::loggedin_userid())
    {
    $_SESSION['user_role']='Subscriber';
    }
    header("Location:users.php");
}

public static function getCategories()
{
    global $conn;
    $categories='';
    $query="select * from categories";
    $result=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        $cat_title=$row['cat_title'];
        $cat_id=$row['cat_id'];
        $categories.= "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
    }
    return $categories;
}

public static function add()
    {
        // Using an instance method to call the static method
        return self::getInstance()->fullname();
    }

    public static function fullname()
    {
        return 'hello';
    }

    // Instance method for easier mocking
    protected static function getInstance()
    {
        return new self();
    }

public static function check()
{
    // global $conn;
    // print_r($conn);
}

}






?>
