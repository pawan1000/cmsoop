<?php 
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');

session_start();
?>
<?php
class Reset extends Functions
{
   
    public static function resetPassword($username,$email,$password)
    {
        global $conn;
        if(!isset($_SESSION['reset_email']))
        {
            return '<script>alert("Pls Enter the registerd email first"); window.location.href = "/cmsoop/view/index.php";</script>';
        }
        else
        {
            $password=password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
            $query="update users set user_password='$password' where username='$username' and user_email='$email'";
            $result=mysqli_query($conn,$query);
            $_SESSION['reset_email']=null;
            
            // echo 'query execcuted';
            return '<script>alert("Password changed "); window.location.href = "/cmsoop/view/index.php";</script>';
        } 
    }
}


if(isset($_POST['reset']))
{
    echo Reset::resetPassword($_POST['username'],$_POST['email'],$_POST['password']);
}

?>