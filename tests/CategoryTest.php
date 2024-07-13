<?php
include('C:\xampp\htdocs\cmsoop\controller\category_controller.php');
use PHPUnit\Framework\TestCase;
class CategoryTest extends TestCase
{
    protected function setUp() : void
    {
        global $conn;
       // Connection here
    }
    public function testGettingPostCategorywiseOrNot()
    {
        $posts=Category::getPosts('76');
        $this->assertStringContainsString('SpringBoot',$posts);
        $this->assertStringContainsString('2023-11-03',$posts);
    }
}