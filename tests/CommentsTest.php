<?php
include('C:\xampp\htdocs\cmsoop\admin\controller\comments_controller.php');
use PHPUnit\Framework\TestCase;

class CommentsTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
       // Connection here
    }
    public function testApproveRejectDeleteShownForAdmin()
    {
        $_SESSION['username']='pawan';
        // $_SESSION['user_role']='Admin';
        $this->assertStringContainsString('Approve',Comments::showComments());
        $this->assertStringContainsString('Reject',Comments::showComments());
        $this->assertStringContainsString('Delete',Comments::showComments());
    }

    public function testApproveRejectDeleteNotShownForSubscriber()
    {
        $_SESSION['username']='vishal';
        // $_SESSION['user_role']='Subscriber';
        $this->assertStringNotContainsString('Approve',Comments::showComments());
        $this->assertStringNotContainsString('Reject',Comments::showComments());
        $this->assertStringNotContainsString('Delete',Comments::showComments());
    }
}