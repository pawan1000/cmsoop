<?php
include('C:\xampp\htdocs\cmsoop\controller\search_controller.php');
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
   // Connection here
    }

    public function testGettingNoPostOuput()
    {
        $this->assertStringContainsString('No Posts Available for this Search',Search::getPosts('test'));     
    }

    public function testGettingPostWithTagsMentioned()
    {
        $this->assertStringContainsString('Python library that provides a simple yet powerful data structure',Search::getPosts('data science'));     
    }
}