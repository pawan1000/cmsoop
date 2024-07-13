<?php
include('C:\xampp\htdocs\cmsoop\controller\navigation_controller.php');
use PHPUnit\Framework\TestCase;

class NavigationTest extends TestCase
{
    protected function setUp(): void
    {
        global $conn;
        // Connection here
    }
    public static function categoryProvider()
    {
        return [
            ['php'],
            ['data science'],
            ['javascript'],
            ['java'],
            ['testing'],
            ['Home']
        ];
    }
/**
 * @dataProvider categoryProvider
 */
public function testAllCategoriesAreShownOrNot($navContent)
    {
        $this->assertStringContainsStringIgnoringCase($navContent,Navigation::showNavigation());
        
    }




    public function testEditPostIsShownWhenLoggedIn()
    {
        $_GET['p_id']=24;
        session_start();
        $_SESSION['user_role']='Admin';
        $_SESSION['username']='pawan';
        $this->assertStringContainsString('Edit Post',Navigation::showNavigation());
    }   

    public function testEditPostIsNotShownWhenLoggedIn()
    {
        $_GET['p_id']=24;
        session_start();
        $_SESSION['user_role']='Admin';
        $_SESSION['username']='vishal';
        $this->assertStringContainsString('Edit Post',Navigation::showNavigation());
    }


}