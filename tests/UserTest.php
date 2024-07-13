<?php
include('C:\xampp\htdocs\cmsoop\controller\login_controller.php');
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }

    public function testLoginFunctionality()
    {
       $is_login= User::login_user('ds','pawan');
      $this->assertEquals( "Login failed. Please check your username and password.",$is_login);

      //other testing is done on ui 
    }
}