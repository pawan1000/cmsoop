<?php
include('C:\xampp\htdocs\cmsoop\controller\post_controller.php');
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
        session_start();
        $_SESSION['username']='pawan';
        $_SESSION['user_role']='Admin';
    }
    public function testGettingCorrectPostLikesPresentInScript()
    {
        $this->assertStringContainsString('pawan@gmail.com',Post::getPosts(24));
        // echo Post::getPosts(24);
    }
}