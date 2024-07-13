<?php  include('C:\xampp\htdocs\cmsoop\view\functions.php');?>
<?php session_start();?>
<?php 
    class AdminNavigation extends Functions
    {   
        public static function pageName()
        {
            return basename($_SERVER['PHP_SELF']);
        }
        
        public static function showTopNavbar()
        {
            $navigation='<ul class="nav navbar-right top-nav">
                            <li class='.(self::pageName() == 'index.php'?"active":"").'>
                                <a href="/cmsoop/view/index.php"><i class="fa fa-fw fa-home"></i>HOME SITE</a>
                            </li>
                            <li class='.(self::pageName() == 'login.php'?"active":"").'>
                                <a href="/cmsoop/controller/login_controller.php"><i class="fa fa-fw fa-power-off"></i> LOGOUT</a>
                            </li>
                        </ul>';
            return $navigation;
        }
    
        public static function showSideNavbar()
        {
            $navigation= '<div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav side-nav">
                                <li class="' . (self::pageName() == 'index.php' ? 'active' : '') . '">
                                    <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> My Data</a>
                                </li>';
                                if (self::is_admin())
                                {
                                    $navigation.= '<li class="' . (self::pageName() == 'dashboard.php' ? 'active' : '') . '">
                                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                                    </li>';
                                }
    
                $navigation.=   '<li class="' . (self::pageName() == 'posts.php' ? 'active' : '') . '">
                                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown">
                                        <i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i>
                                    </a>
                                    <ul id="posts_dropdown" class="collapse">
                                        <li>
                                            <a href="posts.php">View All Posts</a>
                                        </li>
                                        <li>
                                            <a href="posts.php?source=add_post">Add Posts</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="' . (self::pageName() == 'categories.php' ? 'active' : '') . '">
                                    <a href="./categories.php"><i class="fa fa-fw fa-desktop"></i> Categories</a>
                                </li>
                                <li class="' . (self::pageName() == 'comments.php' ? 'active' : '') . '">
                                    <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
                                </li>
                                <li class="' . (self::pageName() == 'users.php' ? 'active' : '') . '">
                                    <a href="javascript:;" data-toggle="collapse" data-target="#demo">
                                        <i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i>
                                    </a>
                                    <ul id="demo" class="collapse">
                                        <li>
                                            <a href="users.php">View All Users</a>
                                        </li>
                                        <li>
                                            <a href="users.php?source=add_user">Add Users</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="' . (self::pageName() == 'profile.php' ? 'active' : '') . '">
                                    <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
                                </li>
                            </ul>';
            return $navigation;
        }
    }
    
    ?>

