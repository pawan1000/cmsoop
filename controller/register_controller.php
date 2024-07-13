<?php
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');

?>
<?php 
    class Register
    {
        public static function username_exists($username)
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
        public static function email_exists($email)
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

        public static function register_user($username,$email,$password)
        {
            global $conn;
            $username=mysqli_real_escape_string($conn,$username);
            $email=mysqli_real_escape_string($conn,$email);
            $password=mysqli_real_escape_string($conn,$password);
            if(self::username_exists($username))
            {
                return "<script>
                        alert('Username already exists');
                        window.location.href = '/cmsoop/view/registration.php';
                      </script>";
            }
            else if(self::email_exists($email))
            {
                return " <script>
                        alert('Email already exists');
                        window.location.href = '/cmsoop/view/registration.php';
                      </script>";
            }
            else
            {
                if(!empty($username)&&!empty($password)&&!empty($email))
                {
                    $_SESSION['username']=$username;
                    $_SESSION['logged_in']=true;
                    $_SESSION['user_role']='Subscriber';
                    $password=password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
                    $query="insert into users(username,user_email,user_password,user_role) values('$username','$email','$password','Subscriber')";
                    $insert_result=mysqli_query($conn,$query);
                    return "<script>alert('You have registered succesfully')</script>";
                }
                else
                {
                    echo "<script>alert('Please Fill the Details')</script>";
                }
                return header("Location: /cmsoop/view/index.php"); 
            }  
        }
    }
?>
<?php
    if(isset($_POST['Register']))
        {
            echo Register::register_user($_POST['username'],$_POST['email'],$_POST['password']) ;
        }
?>