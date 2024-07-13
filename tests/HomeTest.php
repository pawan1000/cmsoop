<?php
include('C:\xampp\htdocs\cmsoop\controller\index_controller.php');
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }

    public function testGettingPostWithLimit()
    {
        $posts=Home::getPosts();
        $this->assertStringContainsString('57',$posts);
    }
    public function testGettingNoPostsMessageWhenStatusIsDraft()
    {
        // $this->assertEquals("No Posts",Home::getPosts()); // changing all posts status to draft
        $this->assertStringNotContainsString('59',Home::getPosts()); //fetching only 5 posts so this will fail

    }

    public function testPageNumbersAreShownOrNot()
    {
        $pageno=Home::showPageNo();
        $this->assertStringContainsString('page=1',$pageno);
        $this->assertStringContainsString('page=2',$pageno);
        $this->assertStringNotContainsString('page=3',$pageno);//It will fail because pageno not contain page=3


    }
}