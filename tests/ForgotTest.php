<?php
include('C:\xampp\htdocs\cmsoop\controller\forgot_controller.php');
use PHPUnit\Framework\TestCase;

class ForgotTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
       // Connection here
    }
   
    public function testThatGettingEmail()
    {
        $email=Forgot::getEmail('pawan22@gmail.com');//Email Not Exisits
        $this->assertEquals('test',$_SESSION['reset_email']);
        $this->assertEquals('<script>alert("Email Does Not Exist"); window.location.href = "/cmsoop/view/index.php";</script>',$email);
    }
}
?>
