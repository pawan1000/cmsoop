<?php  require_once('C:\xampp\htdocs\cmsoop\view\functions.php');?>
<?php session_start();?>
<?php 


class Categories
{
    public static function addCategory()
    {
        global $conn;
        if (isset($_POST['submit'])) 
        {
            Functions::add_category($_POST['cat_title']);
        }
        
        $addCategoryform= '<div class="col-xs-6">';
                if(Functions::get_userrole()=='Admin')
                {
                    $addCategoryform.=' <!-- form for adding new category -->
                                <form action="categories.php" method="POST">
                                    <div class="form-group">
                                        <label for="cat_title">Add Category</label>
                                        <input type="text" required class="form-control" name="cat_title" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                                    </div>
                                </form>';
                }
            return $addCategoryform.(self::editCategory());
        // self::editCategory();
        // self::showCategories();
    }
    public static function showCategories()
    {
        global $conn;
        $showCategoriesTable= '<div class="col-xs-6">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category Title</th>';
                            if(Functions::get_userrole()=='Admin')
                            {
                                $showCategoriesTable.='<th>Delete</th>
                                                       <th>Edit</th>';
                            }
$showCategoriesTable.='</tr>
                    </thead>
                    <tbody>';
                            if($_SESSION['user_role']=='Admin')
                            {
                                $query = "select * from categories";
                            }
                            else
                            {
                                $user_id=Functions::loggedin_userid();
                                $query = "SELECT DISTINCT categories.cat_id, categories.cat_title
                                          FROM posts
                                          RIGHT JOIN categories ON posts.post_category_id = categories.cat_id
                                          ORDER BY categories.cat_id";
                            }
                            $result = mysqli_query($conn, $query);
                            if(mysqli_num_rows($result)>0)
                            {
                                while ($row = mysqli_fetch_assoc($result)) 
                                {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    $showCategoriesTable.= "<tr>";
                                    $showCategoriesTable.= "<td>$cat_id</td>";
                                    $showCategoriesTable.= "<td>$cat_title</td>";
                                    if(Functions::get_userrole()=='Admin')
                                    {
                                        $showCategoriesTable.= "<td><a class='btn btn-danger' onClick='return check_delete();' href='categories.php?delete={$cat_id}'>Delete</a></td>";
                                        $showCategoriesTable.= "<td><a class='btn btn-success' href='categories.php?edit={$cat_id}'>Edit</a></td>";
                                    }
                                    $showCategoriesTable.= "</tr>";
                                }
                            }
                            else
                            {
                                if(Functions::get_userrole()=='Admin')
                                {
                                    $showCategoriesTable.= "<tr>
                                                                <td colspan='4' style='text-align: center;'><h1>No Records Found</h1></td>
                                                            </tr>";
                                }
                                else
                                {
                                    $showCategoriesTable.= "<tr>
                                                                <td colspan='2' style='text-align: center;'><h1>No Records Found</h1></td>
                                                            </tr>";
                                }
                                
                            }
        $showCategoriesTable.='       </tbody>
                                    </table>
                                </div>';

       return $showCategoriesTable;             
    }
    
    public static function editCategory()
    {
        if (isset($_POST['update_category']))
        {
            Functions::update_category($_POST['cat_title'],$_POST['cat_id']); 
        }
        if (isset($_GET['delete'])) 
        {
            Functions::delete_category($_GET['delete']);
        }
        global $conn;
       $editCategoryForm=' <form action="categories.php" method="POST">';
                if (isset($_GET['edit'])) 
                {
                    $editCategoryForm.= '<label for="cat_title">Edit Category</label>';
                    $cat_id = $_GET['edit'];
                    $query = "select * from categories where cat_id=$cat_id";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result)<=0)
                    {
                        Functions::redirect('/cms/admin/categories.php');
                        exit();
                    }
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        $cat_id    = $row['cat_id'];
                        $cat_title = $row['cat_title'];
            
                        $editCategoryForm.='<div class="form-group">
                                                <input value="'.$cat_id.'" type="text" class="form-control" name="cat_id" readonly>
                                            </div>
                                            <div class="form-group">
                                                <input value="'.$cat_title.'"type="text" class="form-control" name="cat_title">
                                            </div>';
                    }
                
                    $editCategoryForm.='<div class="form-group">
                                <input type="submit" class="btn btn-primary" name="update_category" value="Update Category">
                             </div> ';
                }        
        $editCategoryForm.= '</form>
        </div> <!--ADd Category Form -->';
         
        return $editCategoryForm.(self::showCategories());
    }   


    
}


?>