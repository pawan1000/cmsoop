<?php 
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');
session_start();
?>
<?php
class Forgot extends Functions
{
    public static function getEmail($email)
    {
        if(self::email_exists($email))
        {
            $_SESSION['reset_email']=$email;
            return self::redirect('/cmsoop/view/reset.php');
        }
        else
        {
            $_SESSION['reset_email']=null;
            return '<script>alert("Email Does Not Exist"); window.location.href = "/cmsoop/view/index.php";</script>';
        }
    }
}


if(isset($_POST['email']))
{
    echo Forgot::getEmail($_POST['email']);
}

?>