<?php
    // php include file to query database for passwords. 
    
    // get userID from session
    $userId = $_SESSION["userID"];
    $key = $_SESSION["userKey"]; 
    
    // query for database
    $query  = "SELECT * ";
    $query .= "FROM saved_password ";
    $query .= "WHERE user_id = {$userId} ";
    $query .= "LIMIT 1;";
    
    $passSet = mysqli_query($connection, $query);
    
    confirmQuery($passSet);
    $pass = mysqli_fetch_assoc($passSet);
    if(!$pass){
        //error of some ilk
    }
    // base64 decode     
    $encryptedPassword = base64_decode($pass["encrypted_password"]);
    $encryptIv = base64_decode($pass["encrypt_iv"]);    
    
    $decryptedPassword = decryptPassword($encryptedPassword, $key, $encryptIv);
?>