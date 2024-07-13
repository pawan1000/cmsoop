<?php  require_once('C:\xampp\htdocs\cmsoop\view\functions.php');?>
<?php session_start();?>
<?php
class Comments
{
    public static function showComments()
    {
        if(isset($_GET['delete']))
        {
            Functions::delete_comment($_GET['delete']);
        }

        if(isset($_GET['reject']))
        {
            Functions::reject_comment($_GET['reject']);
        }

        if(isset($_GET['approve']))
        {
            Functions::approve_comment($_GET['approve']);
        }
        global $conn;
        $comments= '<table class="table table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Email</th>
                        <th>In Response to</th>
                        <th>Date</th>';
                        if(Functions::get_userrole()=='Admin')
                        {
                            $comments.='<th>Status</th>
                            <th>Delete</th>';
                        }
                        $comments.='</tr>
                </thead>
                <tbody>';
                        $query="select comments.*,posts.* from posts inner join comments on posts.post_id=comments.comment_post_id";
                        $result=mysqli_query($conn,$query);
                        if(mysqli_num_rows($result)>0)
                        {    
                            while ($row = mysqli_fetch_assoc($result))
                            {
                                $comment_post_id = $row['comment_post_id'];
                                $comment_id = $row['comment_id'];
                                $comment_status=$row['comment_status'];
                                $comments.= "<tr>
                                    <td>{$row['comment_id']}</td>
                                    <td>{$row['comment_author']}</td>
                                    <td>{$row['comment_content']}</td>
                                    <td>{$row['comment_email']}</td>
                                    <td><a href='/cmsoop/view/post.php?p_id={$row['post_id']}'>{$row['post_title']}</a></td>
                                    <td>{$row['comment_date']}</td>";
                                    if (Functions::get_userrole() == 'Admin')
                                    {
                                        $comments.= ($comment_status == 'approve') ? 
                                            "<td><a class='btn btn-danger' href='comments.php?reject=$comment_id'>Reject</a></td>" :
                                            "<td><a class='btn btn-success' href='comments.php?approve=$comment_id'>Approve</a></td>";
                                    
                                            $comments.= "<td><a class='btn btn-danger' onClick='return check_delete();' href='comments.php?delete=$comment_id'>Delete</a></td></tr>";
                                    } 
                            }
                        }
                        else
                        {
                            $comments.= "<tr>
                                    <td colspan='8' style='text-align: center;'><h1>No Records Found</h1></td>
                                </tr>";
                        }
                        $comments.='
                </tbody>
            </table>';

        return $comments;
    }
}
?>