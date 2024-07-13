<?php
include('C:\xampp\htdocs\cmsoop\controller\authorposts_controller.php');
use PHPUnit\Framework\TestCase;

class AuthorPostsTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }
    public function testGettingAuthorPostsOrNot()
    {
        $post=Authorposts::getPosts('testAuthor');
        $this->assertStringContainsString("No Posts Available for this Author",$post);
        $post=Authorposts::getPosts('Pawan Kathar');
        $this->assertStringContainsString("NumPy is a Python library that provides a simple yet powerful data structure",$post);
        $post=Authorposts::getPosts('Pawan Kathar');
        $this->assertStringContainsString(" 2023-11-01",$post);
    }
}
?>
