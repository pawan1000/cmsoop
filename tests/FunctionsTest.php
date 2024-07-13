<?php
include ('C:\xampp\htdocs\cmsoop\view\functions.php');

use PhpParser\Node\Expr\FuncCall;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
  
    protected function setUp(): void
    {
        global $conn;
       // Connection here
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
    public function testThatEmailExistsOrNot()
    {
     // Connection here
        $email=Functions::email_exists('pawan@gmaoi.com',$conn);
        $this->assertFalse($email);
        $email=Functions::email_exists('pawan@gmail.com',$conn);
        $this->assertTrue($email);
        $email=Functions::email_exists('',$conn);
        $this->assertFalse($email);
    }

    public function testThatUsernameExitsOrNot()
    {
        // Connection here
        $this->assertTrue(Functions::username_exists('pawan'));
        $this->assertFalse(Functions::username_exists(''));
    }

   public function testThatUserIsLoggedIn()
   {
        $this->assertFalse(Functions::isLoggedIn());
        $_SESSION['user_role']='admin';
        $this->assertTrue(Functions::isLoggedIn());
        unset($_SESSION['user_role']);
        $this->assertFalse(Functions::isLoggedIn());
   }

   public function testThatWeAreGettingLoggedInUserId()
   {
        $loggedinuserid=Functions::loggedin_userid();
        $this->assertSame(false,$loggedinuserid);
   }

   public function testIsUserIsAdmin()
   {
    $_SESSION['username']='pawan';  
    $is_admin=Functions::is_admin();
    $this->assertTrue($is_admin);
   }

   public function testGettingUsernameOrNot()
   {
    $_SESSION['username']='pawan';
    $username=Functions::get_username();
    $this->assertEquals('pawan',$username);
   }

   public function testGettingFullName()
   {
    $_SESSION['user_firstname']='pawan';
    $_SESSION['user_lastname']='kathar';
    $full_name=Functions::get_fullname();
    $this->assertEquals('pawan kathar',$full_name);
   }
   public function testGetttingEmailId()
   {
    $_SESSION['username']='pawan';
    $emailId=Functions::get_emailid();
    $this->assertEquals('pawan@gmail123.com',$emailId);
   }

   public function testUserLikedThisPost()
   {
    $mock=Mockery::mock(Functions::class);
    $mock->shouldReceive('loggedin_userid')->andReturn(53);
    $this->assertEquals(53,Functions::loggedin_userid());
   }

   public function testGettingCorrectPostLikes()
   {
    $this->assertEquals(0,Functions::getpostlikes('25'));
    $this->assertEquals(1,Functions::getpostlikes('24'));
   }

   public function testGettngCorrectPostsCountOrNot()
   {
    // left with data check
    // $result=Functions::get_postscount('');
    // $this->assertEquals(8,$result);

    // $mock = Mockery::mock(Functions::class);
    // $userId = 54;
    // $mock->shouldReceive('loggedin_userid')->andReturn($userId);
    // $this->assertEquals(6,Functions::get_postscount('my_data'));
    // $mock->shouldReceive('isLoggedIn')->andReturn(true); // Set the desired behavior for isLoggedIn

    // $result=Functions::get_postscount('my_data');
    // $this->assertEquals(6,$result);
// $this->assertEquals(54,$mock->loggedin_userid());

$_SESSION['username']='pawan';
$_SESSION['user_role']='admin';

$this->assertEquals(8,Functions::get_postscount('dashboard'));
$this->assertEquals(6,Functions::get_postscount('my_data'));
   }

  

   public function testGettngCorrectCommentsCountOrNot()
   {
    $_SESSION['username']='pawan';
    $_SESSION['user_role']='admin';
    $this->assertEquals(7,Functions::get_commentscount(''));
    $this->assertEquals(6,Functions::get_commentscount('my_data'));
   }

   public function testGettngCorrectCategoriesCountOrNot()
   {
    $_SESSION['username']='pawan';
    $_SESSION['user_role']='admin';
    $this->assertEquals(6,Functions::get_categoriescount(''));
    $this->assertEquals(3,Functions::get_categoriescount('my_data'));
   }

   public function testGettingCorrectUsersCountOrNot()
   {
    $_SESSION['username']='pawan';
    $_SESSION['user_role']='admin';
    $this->assertEquals(6,Functions::get_categoriescount(''));
    $this->assertEquals(9,Functions::get_userscount());
   }

   public function testGettingCorrectUserRoleOrNot()
   {
    $_SESSION['user_role']='Admin';
    $_SESSION['username']='pawan';
    $this->assertEquals('Admin',Functions::get_userrole());
   }

   public static function categoriesProvider()
   {
    return [
        ['php'],
        ['data science'],
        ['javascript'],
        ['java'],
        ['testing'],
    ];
   }
   /**
 @dataProvider categoriesProvider 
 */
   public function testGettingCategoriesOrNot($string_to_check)
   {
    $this->assertStringContainsStringIgnoringCase($string_to_check,Functions::getCategories());
    $categories=Functions::getCategories();
    $this->assertStringContainsString('Data Science',$categories);
    $this->assertStringNotContainsString('php124',$categories);


   }

   public function testAdd()
{
$mock=Mockery::mock(Functions::class);
    $mock->shouldReceive('fullname')->andReturn('bye');
    $this->assertEquals('bye',$mock::add());
    $mock->shouldHaveReceived('fullname')->once();
    $mock->shouldHaveReceived('add')->once();  // Set expectation for the add method
    $mock->shouldNotHaveReceived('anyOtherMethod');
    
}
