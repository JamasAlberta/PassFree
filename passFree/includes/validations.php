<?php
// validations.php
// functions to pass in inputs array and error array.
// if input error, adds index and error message to errorArray() (associative array) and returns that array.
// if no error, returns errorArray() as is.
// declare errorArray (associative array) and errorMessages (string)
$errorArray = array(); 

$genericWords = array("boyfriend","girlfriend","phone number","phone no","actor",
    "movie","film","musician","band","author","artist","pet","pets","pet's","high school",
    "primary school","school","movie","book","maiden","teacher","birthplace",
    "birth place","home town");

// validates name based on name input and stores any errors in errorArray.
function validateName($name){
	global $errorArray;
	
	$min = 2;
	$max = 100;
	$nameLen = strlen($name);
	
	if (empty($name)){ // if the name input is empty
		$errorArray["name"] = "Please Enter Name";
	}
	elseif ($nameLen < $min){ // if the name input is too short
		$errorArray["name"] = "Name Is Too Short!";
	}
	elseif ($nameLen > $max){ // if the name input is too long
		$errorArray["name"] = "Name Is Too Long!"; 
	}
	elseif (!preg_match ("/^[a-zA-z ]*$/",$name)){ // if the name input doesn't only include letters
    	$errorArray["name"] = "Error! Only Letters and Spaces Allowed!";
    }
}

// validates email based on email input and stores any errors in errorArrray.
function validateEmail($email){
	global $errorArray;
	$max = 255;
	$emailLen = strlen($email);
	
	if (empty($email)){
		$errorArray["email"] = "Please Enter Email";
	}
	elseif ($emailLen > $max){
		$errorArray["email"] = "Email Is Too Long!";
	}
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$errorArray["email"] = "Incorrect Email Format!";
	}
}

// function to pass in an array of questions to be checked
function checkQuestionArray($array) {
	for ($i = 0; $i < count($array); $i++) {
        if (!checkQuestion($array[$i])) {
            return false;
        }
    }
    return true;
}



// Checks a string to see if it has any of the full generic words in it (not case senstive) and is not blank
function checkQuestion($question) {
	global $genericWords;
    
    // if the question is less than 5 characters return false
    if (strlen($question) < 5) {
        return false;
    }
    
    // check for each generic word in the string
    for ($i = 0; $i < count($genericWords); $i++) {
        
        // Checks only for full words in list.. 
        $regex = "/\\b";
        $regex .= $genericWords[$i];
        $regex .= "\\b/";
        
        if (preg_match($regex, $question)) {
            return false;
        }
    }

    // all good otherwise
    return true;
}


// function to pass through an array of answers to be checked
function checkAnswerArray($array) {
    for ($i = 0; $i < count($array); $i++) {
        if (!checkAnswer($array[$i])) {
            return false;
        }
    }
    return true;
    
	
}

// function to test answer is at least 5 characters
function checkAnswer($answer) {
    
    if (strlen($answer) < 5) {
        return false;
    }
    else
    {
        return true;
    }
    
}


?>



