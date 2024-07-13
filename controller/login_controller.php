<?php
session_start();
require_once('C:\xampp\htdocs\cmsoop\view\functions.php');
?>
<?php
class User
{
    public static function login_user($username,$password)
    {
        global $conn;
        $username = $username;
        $password = $password;
        $query = "select * from users where username='$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row && (password_verify($password, $row['user_password']))) 
        {
            // Authentication successful
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_firstname'] = $row['user_firstname'];
            $_SESSION['user_lastname'] = $row['user_lastname'];
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['logged_in'] = true;

            if ($row['user_role'] == 'Admin') 
            {
                header("Location: /cmsoop/admin/view");
            } 
            elseif ($row['user_role'] == 'Subscriber') 
            {
                header("Location:/cmsoop/admin/view/profile.php");
            }
            exit();
        } 
        else
        {
            echo "Login failed. Please check your username and password.";
        }
    }

    public static function logout_user()
    {
        $_SESSION['username']=null;
        $_SESSION['user_firstname']=null;
        $_SESSION['user_lastname']=null;
        $_SESSION['user_role']=null;
        session_destroy();
        header("Location:../view/index.php");
    }
    
}
if (isset($_POST['Login']))
{
    User::login_user($_POST['username'],$_POST['password']);
}
else
{
   User::logout_user();
}

?>

