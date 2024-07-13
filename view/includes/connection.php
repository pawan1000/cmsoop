<?php
    class Connection
    {
        private static $servername = "";
        private static $username = "";
        private static $password = "";
        private static $dbname = "";
             
        public static function make_connection()
        {
            $conn = mysqli_connect(self::$servername, self::$username, self::$password, self::$dbname);
            return $conn;
        }
    }

    $conn= Connection::make_connection();
// if($conn)
// {
//     echo "connected suceesfully";
// }
?>