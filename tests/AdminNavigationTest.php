<?php
include('C:\xampp\htdocs\cmsoop\admin\controller\adminnavigation_controller.php');
use PHPUnit\Framework\TestCase;

class AdminNavigationTest extends TestCase
{
    
    protected function setUp(): void
    {
        global $conn;
        $conn = mysqli_connect('localhost','root','','cms');
    }

    public function testAllItemsShownForAdmin()
    {
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('Dashboard',AdminNavigation::showSideNavbar());
    }

    public function testDashboardNotShownToSubscriber()
    {
        
        $_SESSION['username']='kelvin';
        $this->assertStringNotContainsString('Dashboard',AdminNavigation::showSideNavbar());
    }

    public function testLogoutButtonIsPresent()
    {
        $this->assertStringContainsString('LOGOUT',AdminNavigation::showTopNavbar());
    }
}