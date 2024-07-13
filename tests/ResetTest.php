<?php
include ('C:\xampp\htdocs\cmsoop\controller\reset_controller.php');
use PHPUnit\Framework\TestCase;

class ResetTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }
   public function testAbleToResetPassword()
   {
    $this->assertEquals('<script>alert("Pls Enter the registerd email first"); window.location.href = "/cmsoop/view/index.php";</script>',Reset::resetPassword('admin','admin@gmail.com','admin'));
   }
   public function testPasswordChangingSuccesfully()
   {
    $_SESSION['reset_email']=true;
    $this->assertEquals('<script>alert("Password changed "); window.location.href = "/cmsoop/view/index.php";</script>',Reset::resetPassword('admin','admin@gmail.com','admin'));
   }
}