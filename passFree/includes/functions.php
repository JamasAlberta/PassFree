<?php
    // function to redirect users to a particular page.  
    // Use this to redirect a user away from pages if they aren't logged in
    function redirectTo($newLocation) {
        header ("Location: " . $newLocation);
        exit;
    }
    
    // function to determine whether use is logged in or not.
    // checks whether userID field is set in $_SESSION
    function loggedIn() {
        return isset($_SESSION["userID"]) && !empty($_SESSION["userID"]);
    }

    // confirm whether user is logged in
    // if not redirect to index.php
    function loginConfirm() {
        if (!loggedIn()) {
            redirectTo("index.php");
        }
    }
    // logout function which clears sessions.
    function logOut(){
        // removal all session variables
        session_unset(); 
        // destroy the session 
        session_destroy(); 
    }
    
    // prepare any string for MySQL database use.
    function prepMysql($string){
		global $connection;
		
		return mysqli_real_escape_string($connection,$string);
	}
    
    // function to confirm a result from the query
    function confirmQuery($dataSet) {
        if(!$dataSet) {
            die("Database query failed.");
        }
    }
    
    // find user exists in database by email address
    function findUserByEmail($email){
        global $connection;
        
        // escape email input string from user
        $escapedEmail = prepMysql($email);
        
        $query = "SELECT * ";
        $query .= "FROM user ";
        $query .= "WHERE email = '{$escapedEmail}' ";
        $query .= "LIMIT 1";
        $userSet = mysqli_query($connection, $query);
        //check query for a result
        confirmQuery($userSet);
        if($user = mysqli_fetch_assoc($userSet)) {
            return $user;
        } else {
            return null;   
        }
    }
    
    // function to determine whether name and email exists in database
    function checkUserExists($name, $email) {
        $user = findUserByEmail($email);
        if ($user) {
            // found email, check name to confirm user
            if ($user["name"] == $name){
                // name matches in database return user array
                return $user;
            } else {
                // name does not match
                return false;
            }
            
        } else {
            // user not found
            return false;
        }
    }
    
    // function to encrypt the users secret answers
    function encryptAnswers($answers){
        return password_hash("$answers", PASSWORD_DEFAULT);
    }
    
    // function to verify the users secret answers
    function checkAnswers($answers, $existingAnswer) {
        return password_verify($answers, $existingAnswer);
    }
    
    // function to decrypt saved password using openssl php function
    function decryptPassword($encryptedPassword, $key, $iv){
        $method = "aes-256-ctr";
        $options = OPENSSL_RAW_DATA;
        $keyHash = openssl_digest($key, "sha256", true);
        
        // decrypt using openssl_decrypt
        return openssl_decrypt ( $encryptedPassword, $method, $keyHash, 
                                                               $options, $iv );
    }   
    
    // function to encrypt saved password using openssl php function
    function encryptPassword($passwordData,$method, $key, $iv){
        $options = OPENSSL_RAW_DATA;
        $keyHash = openssl_digest($key, "sha256", true);
        
        // encrypt using openssl_encrypt function
        return openssl_encrypt ( $passwordData, $method, $keyHash, $options, $iv );
    }
?>


