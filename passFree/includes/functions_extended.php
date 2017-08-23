<?php

/*
-------------- SQL -----------------------------

Updating User Relation to include attributes:
* attempts_counter INT
counter for login attempts

* last_login DATETIME 
records the last login attempt time

On login.php, after user attempts to login with chosen answers, 
it will increment attempts_counter and set last_login time to NOW().
If user attempt is successful, it will check if attempts_counter exceeds 
limit AND comparison between now() and last_login is over over 10 minutes.
*/

//10 minutes to lockout
$TIME_PERIOD = 10;
//5 attempts until lockout
$ATTEMPTS_NUMBER = 5;




function confirmUserLogin($userID)
{
    global $connection;
    global $TIME_PERIOD;
	global $ATTEMPTS_NUMBER;
    
    /*
    * Query for user table. Case checks if last_login is not null, and if time between last login and now is greater
    * than TIME_PERIOD. TIME_PERIOD to be 10 minutes. userID matches session{userID}.
    */
    
    $query =  "SELECT attempts_counter, (CASE when DATE_ADD(last_login, INTERVAL ";
    $query .= "{$TIME_PERIOD} ";
    $query .= "MINUTE)> NOW() then 1 else 0 end) as Denied ";
    $query .= "FROM user ";
    $query .= "WHERE user_id = {$userID}; ";
    
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $loginData = mysqli_fetch_assoc($result);
    
    
    //Verify that at least one login attempt is in database.
    if (!$loginData) {
        return 0;
    }
    
    // if attempts exceed ATTEMPTS_NUMBER limit of 5
    if ($loginData["attempts_counter"] >= $ATTEMPTS_NUMBER)
    {
        // if time since last login is over TIME_PERIOD limit of 10 minutes
        if ($loginData["Denied"] == 1)
        {
            return 0;
        }
        else
        {
            // clears login attempts
            clearLoginAttempts($userID);
            return 1;
        }
    }
    else
    {
    clearLoginAttempts($userID);
    return 1;
    }
}

function addLoginAttempt($userID){
    global $connection;
    global $TIME_PERIOD;
	global $ATTEMPTS_NUMBER;
	
    // Increase number of login attempts
    // Set last login attempt if required
    $query =  "SELECT * ";
    $query .= "FROM user ";
    $query .= "WHERE user_id = {$userID}; ";
    
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $loginData = mysqli_fetch_assoc($result);
    
    // if loginData is not null
    if($loginData)
    {
        // declare attempts variable based on current query value and increment by 1
        $attempts = $loginData["attempts_counter"]+1;
        
        // if total attempts equals to or greater than ATTEMPTS_NUMBER of 5
        if ($attempts >= $ATTEMPTS_NUMBER) {
            
            $query = "UPDATE user ";
            $query .= "SET attempts_counter = {$attempts} ,";
            $query .= "last_login = NOW() ";
            $query .= "WHERE user_id = {$userID}; ";
            
            $result = mysqli_query($connection, $query);
            confirmQuery($result);
        }
        //
        else {
            
            $query = "UPDATE user ";
            $query .= "SET attempts_counter = {$attempts} ";
            $query .= "WHERE user_id = {$userID}; ";
            
            $result = mysqli_query($connection, $query);
            confirmQuery($result);
        }
    }
}

function clearLoginAttempts($userID) {
    global $connection;
    $query = "UPDATE user ";
    $query .= "SET attempts_counter = 0 ";
    $query .= "WHERE user_id = {$userID}; ";
    
    $result = mysqli_query($connection, $query);
    return confirmQuery($result); 
}
    
    
?>


