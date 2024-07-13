<?php

use PHPUnit\Framework\TestCase;

include('C:\xampp\htdocs\cmsoop\admin\controller\categories_controller.php');

class CategoriesTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }
    public function testAddCategoriesFormIsShownForAdmin()
    {
        $_SESSION['user_role']='Subscriber';
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('Add Category',Categories::addCategory());
    }

    public function testAddCategoriesFormIsNotShownForSubscriber()
    {
        $_SESSION['user_role']='Subscriber';
        $_SESSION['username']='vishal';
        $this->assertStringNotContainsString('Add Category',Categories::addCategory());
    }

    public function testEditAndDeleteOptionAreShownForAdmin()
    {
        $_SESSION['user_role']='Admin';
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('Edit',Categories::showCategories());
        $this->assertStringContainsString('Delete',Categories::showCategories());
    }

    public function testEditAndDeleteOptionAreNotShownForAdmin()
    {
        $_SESSION['user_role']='Subscriber';
        $_SESSION['username']='vishal';
        $this->assertStringNotContainsString('Edit',Categories::showCategories());
        $this->assertStringNotContainsString('Delete',Categories::showCategories());
    }
}