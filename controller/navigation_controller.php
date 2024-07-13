<?php
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');
?>
<?php
class Navigation extends Functions
{
    public static function pageName()
    {
       return basename($_SERVER['PHP_SELF']);
    }

    public static function getCategories()
    {
        global $conn;
        $categoriesHTML = '';
        $query="select * from categories";
        $result=mysqli_query($conn,$query);
        while($row=mysqli_fetch_assoc($result))
        {
            $cat_title=$row['cat_title'];
            $cat_id=$row['cat_id'];
            $category_class='';
            $registration_class='';
            $pageName=basename($_SERVER['PHP_SELF']);
            $registration='registration.php';
            if(isset($_GET['category'])&& $_GET['category']==$cat_id)
            {
                $category_class='active';   
            }
            else if($pageName==$registration)
            {
                $registration_class='active';
            }
            $categoriesHTML.= "<li class='$category_class'><a href='/cmsoop/view/category.php?category={$cat_id}'>{$cat_title}</a></li>";
        }
    return $categoriesHTML;
    }

    public static function showNavigation()
    {
        $navbar='           <li class='.(self::pageName() == 'index.php'?"active":"").' >
                            <a href="index.php">Home</a>
                            </li>';
                            $navbar.=self::getCategories();
                            $navbar.= ' <li>
                                            <a href="/cmsoop/admin/view/index.php">Admin</a>
                                        </li>';
                        
                            if(!isset($_SESSION['username']))
                            {
                            $navbar.= ' <li class='.(self::pageName() == 'registration.php'?"active":"").' >
                                        <a href="/cmsoop/view/registration.php">Register</a>
                                        </li>';
                            }
                            if(isset($_SESSION['user_role']))
                            {
                                if(isset($_GET['p_id']))
                                {
                                    global $conn;
                                    $the_post_id=$_GET['p_id'];
                                    $query="select * from posts where post_id='$the_post_id'";
                                    $result=mysqli_query($conn,$query);
                                    $row=mysqli_fetch_assoc($result);
                                    if(self::loggedin_userid()==$row['user_id'])
                                    {
                                        $navbar.= "<li><a href='/cmsoop/admin/view/posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a></li>";
                                    }
                                }

                            }

        return $navbar;

    }
}
?>