<?php
include('C:\xampp\htdocs\cmsoop\admin\controller\users_controller.php');
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    protected function setUp() : void
    {
        global $conn;
       // Connection here
    }
    public function testAllUsersAreShown()
    {
        $this->assertStringContainsString('newuser',Users::showUsers());
        $this->assertStringContainsString('jdjjfjenfjndjfnds',Users::showUsers());
    }

    
}