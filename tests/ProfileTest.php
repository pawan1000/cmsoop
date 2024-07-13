<?php
include('C:\xampp\htdocs\cmsoop\admin\controller\profile_controller.php');
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }
    public function testGettingLoggedInUserDetailsInForm()
    {
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('Pawan',Profile::getDetails());
        $this->assertStringContainsString('Kathar',Profile::getDetails());
        $this->assertStringContainsString('pawan',Profile::getDetails());
        $this->assertStringContainsString('pawan@gmail.com',Profile::getDetails());
    }

    public function testProfileIsUpdated()
    {
        $_POST['edit_user']=true;
        $_POST['user_firstname']='Pawan';
        $_POST['user_lastname']='Kathar';
        $_POST['username']='Pawan';
        $_POST['user_email']='pawan@gmail.com';
        Profile::updateProfile();
        // $_SESSION['username']='pawan';
        $this->assertStringContainsString('pawan@gmail.com',Profile::showProfile($_POST['user_firstname'],$_POST['user_lastname'],$_POST['username'],$_POST['user_email']));
    }
}