<?php
    
    // connect to Cloud9 MYSQL database
    // cloud 9 relevant credentials
    define("DB_SERVER", getenv('IP'));
    define("DB_USER", getenv('C9_USER'));
    define("DB_PASS", "");
    define("DB_NAME", "pass_free");
    define("DB_PORT", 3306);
   
    // create the connection
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
    // check if connection is successful
    // probably need to do a return false or true
    // rather than echoing to screen.
    if ($connection->connect_errno ) {
        die ("Database connection failed:" .
            $connection->connect_error . " ("
            . $connection->connect_errno . ")"
            );
    }

?>