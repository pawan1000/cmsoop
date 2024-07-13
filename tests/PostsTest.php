<?php
include('C:\xampp\htdocs\cmsoop\admin\controller\posts_controller.php');
use PHPUnit\Framework\TestCase;

 class PostsTest extends TestCase
 {
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }
    public  function testPostsAreNotEmpty()
    {
        $this->assertNotEmpty(posts::getPosts());
    }

    public function testShowingAllPostsForAdmin()
    {
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('vishal patil',posts::getPosts());
        //posts of vishal patil are also shown
    }

    public function testNotShowingAllPostsForSubscriber()
    {
        $_SESSION['username']='vishal';
        $this->assertStringNotContainsString('Pawan Kathar',posts::getPosts());
        //posts of vishal patil are also shown
    }

    public function testTimeRangeIsWorkingProperly()
    {
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('2023-10-13',posts::getPosts('2023-10-05','2023-11-25'));
        // echo posts::getPosts('2023-10-05','	2023-11-25');
    }
 }