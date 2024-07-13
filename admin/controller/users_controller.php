<?php  require_once('C:\xampp\htdocs\cmsoop\view\functions.php');?>
<?php session_start();?>
<?php 
class Users 
{
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
            case 'add_user':include "includes/add_user.php";break;
            case 'edit_user':include "includes/edit_user.php";break;
            default:include "includes/view_all_users.php";
        }
        if(isset($_GET['delete']))
        {
            return Functions::delete_user($_GET['delete']);
        }

        if(isset($_GET['change_to_admin']))
        {
            return Functions::change_to_admin($_GET['change_to_admin']);
        }

        if(isset($_GET['change_to_subscriber']))
        {
            Functions::change_to_subscriber($_GET['change_to_subscriber']);
        }
    }

    public static function showUsers()
    {
        if(isset($_GET['delete']))
        {
           return  Functions::delete_user($_GET['delete']);
        }

        if(isset($_GET['change_to_admin']))
        {
           return Functions::change_to_admin($_GET['change_to_admin']);
        }

        if(isset($_GET['change_to_subscriber']))
        {
            return Functions::change_to_subscriber($_GET['change_to_subscriber']);
        }
        global $conn;
        $users= '<table class="table table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Admin</th>
                        <th>Subscriber</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>';
                    $query="select * from users";
                    $result=mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)>0)
                    {    
                        $rows=mysqli_fetch_all($result,MYSQLI_ASSOC);
                        foreach($rows as $row) 
                        {
                            $user_id=$row['user_id'];
                            $users.="<tr>
                                <td>{$row['user_id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['user_firstname']}</td>
                                <td>{$row['user_lastname']}</td>
                                <td>{$row['user_email']}</td>
                                <td>{$row['user_role']}</td>
                                <td><a class='btn btn-info'    href='users.php?change_to_admin=$user_id'>Admin</a></td>
                                <td><a class='btn btn-success' href='users.php?change_to_subscriber=$user_id'>Subscriber</a></td>
                                <td><a class='btn btn-primary' href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>
                                <td><a class='btn btn-danger'  onClick='return check_delete();' href='users.php?delete=$user_id'>Delete</a></td>
                            </tr>";
                        }
                    }
                    else
                    {
                        $users.= "<tr>
                        <td colspan='10'style='text-align: center;'><h1>No Records Found</h1></td>
                        </tr>";
                    }
                $users.=' </tbody>
            </table>';
        return $users;
    }

    public static function addUser()
    {
        global $conn;
        if(isset($_POST['create_user']))
        {
            $user_firstname=Functions::escape($_POST['user_firstname']);
            $user_lastname=Functions::escape($_POST['user_lastname']);
            $username=Functions::escape($_POST['username']);
            $user_password_hidden=Functions::escape($_POST['user_password']);
            $user_password=Functions::escape(password_hash($_POST['user_password'],PASSWORD_BCRYPT,array('cost'=>12)));
            $user_role=Functions::escape($_POST['user_role']);
            $user_email=Functions::escape($_POST['user_email']);
//-------------------------------------------------//
        $emptyfields=array();
        if (empty($user_firstname))
        {
            $emptyfields[] = "First Name";
        }
        if (empty($user_lastname))
        {
            $emptyfields[] = "Last Name";
        }
        if ($user_role==0)
        {
            $emptyfields[] = "User ROle";
        }
        if (empty($username))
        {
            $emptyfields[] = "Username";
        }
        if (empty($user_password_hidden))
        {
            $emptyfields[] = "PassWord";
        }
        if (empty($user_email))
        {
            $emptyfields[] = "Email";
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
            $query="INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) VALUES ('$username','$user_password','$user_firstname','$user_lastname','$user_email','$user_role')";
            $result=mysqli_query($conn,$query);
            Functions::redirect('/cmsoop/admin/view/users.php');
        }

        }
        return self::showForm($user_firstname,$user_lastname,$user_email,$username,$user_password_hidden,$user_role);
    }

    public static  function showForm($user_firstname,$user_lastname,$user_email,$username,$user_password_hidden,$user_role)
    {
        $addUsersForm= '<form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Firstname</label>
                    <input type="text" class="form-control" name="user_firstname" value="'.$user_firstname.'" >
                </div>
                <div class="form-group">
                    <label for="title">Last Name</label>
                    <input type="text" class="form-control" name="user_lastname" value="'.$user_lastname.'" >
                </div>
                <div class="form-group">
                    <label for="title">Role</label>
                    <select name="user_role" id="">
                        <option value="0">Select options</option>
                        <option value="Admin" ' . ($user_role === 'Admin' ? 'selected' : '') . '>Admin</option>
                        <option value="Subsriber" ' . ($user_role === 'Subsriber' ? 'selected' : '') . '>Subscriber</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Username</label>
                    <input type="text" class="form-control" name="username" value="'.$username.'" >
                </div>
                <div class="form-group">
                    <label for="title">Password</label>
                    <input type="password" class="form-control" name="user_password" value="'.$user_password_hidden.'">
                </div>    
                <div class="form-group">
                    <label for="title">Email</label>
                    <input type="email" class="form-control" name="user_email" value="'.$user_email.'" >
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
                </div>
            </form>';

        return $addUsersForm;
    }

    public static function getDetails($the_user_id)
    {
        global $conn;
        if(isset($_GET['edit_user']))
        {
            $query="select * from users where user_id='$the_user_id'";
            $result=mysqli_query($conn,$query);
            if(mysqli_num_rows($result)<=0)
            {
                echo "<h1>No User Exists</h1>";
                exit();
            }
        return self::showUser($result,$the_user_id);
        }
        else
        {
            header("Location:../admin");
        } 
    }
    public static function showUser($result,$the_user_id)
    {
        self::editUser($the_user_id);
        $row=mysqli_fetch_assoc($result);
        // --------------------------------//
        $user_firstname=$row['user_firstname'];
        $user_lastname=$row['user_lastname'];
        $username=$row['username'];
        $user_role=$row['user_role'];
        $user_email=$row['user_email'];
        $user= '<form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Firstname</label>
                    <input type="text" value="'.$user_firstname.'" class="form-control" name="user_firstname" required>
                </div>
                <div class="form-group">
                    <label for="title">Last Name</label>
                    <input type="text"  value="'.$user_lastname.'" class="form-control" name="user_lastname" required>
                </div>
                <div class="form-group">
                    <label for="title">Role</label>
                    <select name="user_role" id="">
                        <option value="'.$user_role.'">'.$user_role.'</option>';
                            if($user_role=='Admin')
                            {
                                $user.= "<option value='Subscriber'>Subscriber</option>";
                            }
                            else
                            {
                                $user.= "<option value='Admin'>Admin</option>";
                            }
            $user.='</select>
                </div>
                <div class="form-group">
                    <label for="title">Username</label>
                    <input type="text"  value="'.$username.'" class="form-control" name="username" required>
                </div>  
                <div class="form-group">
                    <label for="title">Email</label>
                    <input type="email"  value="'.$user_email.'" class="form-control" name="user_email" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User" required>
                </div>
        </form>';

        return $user;

    }
    public static function editUser($the_user_id)
    {
        global $conn;
        if(isset($_POST['edit_user']))
        {
            $user_firstname=$_POST['user_firstname'];
            $user_lastname=$_POST['user_lastname'];
            $username=$_POST['username'];
            $user_role=$_POST['user_role'];
            $user_email=$_POST['user_email']; 
            $query="update users set username='$username', user_firstname='$user_firstname', user_lastname='$user_lastname', user_email='$user_email', user_role='$user_role' where user_id='$the_user_id'";
            $result=mysqli_query($conn,$query);
            Functions::redirect('users.php');
        }
    }

}
    

?>