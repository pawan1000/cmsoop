<?php  require_once('C:\xampp\htdocs\cmsoop\view\functions.php');?>
<?php session_start();?>
<?php
class Profile
{
    public static function getDetails()
    {
        global $conn;
        if (isset($_SESSION['username']))
        {
            $username = $_SESSION['username'];
            $query = "select * from users where username='$username'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $username = $row['username'];
            return self::showProfile($user_firstname, $user_lastname, $username, $user_email);
        }
    }

    public static function updateProfile()
    {
        global $conn;
        if (isset($_POST['edit_user']))
        {
            $user_firstname = $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $username = $_POST['username'];
            $user_email = $_POST['user_email'];
            $query = "update users set username='$username', user_firstname='$user_firstname', user_lastname='$user_lastname', user_email='$user_email' where username='$username'";
            $result = mysqli_query($conn, $query);
            header("Location:profile.php");
        }
    }

    public static function showProfile($user_firstname, $user_lastname, $username, $user_email)
    {
        self::updateProfile();
        $profileForm=    '<form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Firstname</label>
                        <input type="text" value="' . $user_firstname . '" class="form-control" name="user_firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Last Name</label>
                        <input type="text" value="' . $user_lastname . '" class="form-control" name="user_lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Username</label>
                        <input type="text" value="' . $username . '" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label for="title">email</label>
                        <input type="email" value="' . $user_email . '" class="form-control" name="user_email">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                    </div>
                </form>';

                return $profileForm;
    }
}
?>