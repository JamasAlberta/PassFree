<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php require_once("../passFree/includes/validations.php"); ?>
<?php

    if(isset($_POST["submit"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $attempts = 0;
        
        // could probably do a for loop for below to tidy code
        $question1 = $_POST["question1"];
        $question2 = $_POST["question2"];
        $question3 = $_POST["question3"];
        $question4 = $_POST["question4"];
        $answer1 = trim($_POST["answer1"]);
        $answer2 = trim($_POST["answer2"]);
        $answer3 = trim($_POST["answer3"]);
        $answer4 = trim($_POST["answer4"]);
        
        //check PHP input validations here
        $questions = array($question1, $question2, $question3, $question4);
        $answers = array($answer1, $answer2, $answer3,$answer4);
        
        validateName($name);
        validateEmail($email);
        if (!checkQuestionArray($questions) || !checkAnswerArray($answers)) {
            $errorMessage = "Error! Please ensure all questions and answers are at least 5 characters long.";
        } else if (array_key_exists ("name", $errorArray)) {
            $errorMessage = $errorArray["name"];
        } else {
        
            
            
            // check if user email already exists
            $foundEmail = findUserByEmail($email);
            
            if (!$foundEmail) {
                // Sign User Up
                $safeName = prepMysql($_POST["name"]);
                $safeEmail = prepMysql($_POST["email"]);
                $safeQ1 = prepMysql($_POST["question1"]);
                $safeQ2 = prepMysql($_POST["question2"]);
                $safeQ3 = prepMysql($_POST["question3"]);
                $safeQ4 = prepMysql($_POST["question4"]);
                
                // put questions and answers into an array
                $questions = array("{$safeQ1}", "{$safeQ2}", "{$safeQ3}", "{$safeQ4}");
                $lengthQs = count($questions);
                
                // query to insert new user
                $query  = "INSERT INTO user (";
                $query .= " name, email, last_login, attempts_counter";
                $query .= ") VALUES (";
                $query .= " '{$safeName}', '{$safeEmail}', NOW() ,{$attempts}";
                $query .= ");";
            
                $result = mysqli_query($connection, $query);
                
                if (!$result) {
                    // error of sorts
                }
                
                // find new user_id
                $user = findUserByEmail($safeEmail);
                $userId = $user["user_id"];
                
                // query to insert questions into database
                for ( $x = 0; $x < $lengthQs; $x++ ){
                    $query  = "INSERT INTO question (";
                    $query .= " question, user_id";
                    $query .= ") VALUES (";
                    $query .= "'{$questions[$x]}'";
                    $query .= ", {$userId}";
                    $query .= ")";
                    
                    $result = mysqli_query($connection, $query);
                    if (!$result) {
                        // error of sorts
                    }
                }// end for loop
                
                // concatenate answer1,2,3 and 4 together for login-password hash/salted
                $loginAnswers = $answer1 . $answer2 . $answer3 . $answer4;
                $loginHash = encryptAnswers($loginAnswers);
                
                // query to insert hashed answers into database
                $query  = "INSERT INTO answer (";
                $query .= " hashed_answer, user_id";
                $query .= ") VALUES (";
                $query .= "'{$loginHash}'";
                $query .= ", {$userId}";
                $query .= ")";
                
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    // error of sorts
                }
               
                // create a base encrypted_password for new user
                $passwordData = "Details:  ";
                $key = $answer3 . $answer4;
                $method = "aes-256-ctr";
                $iv_num_bytes = openssl_cipher_iv_length($method);
                $iv = openssl_random_pseudo_bytes($iv_num_bytes);
                
                // openssl_encyrpt using previous defined method and options
                $encryptedPassword = encryptPassword($passwordData, $method, $key, $iv);
                
                // base64 encode results for storage in database.
                $encryptedPasswordEncoded = base64_encode($encryptedPassword);
                $ivEncoded  = base64_encode($iv);
                
                // query to create a saved_password field for new user
                $query  = "INSERT INTO saved_password (";
                $query .= " encrypted_password, encrypt_iv, user_id";
                $query .= ") VALUES (";
                $query .= "'{$encryptedPasswordEncoded}'";
                $query .= ", '{$ivEncoded}'";
                $query .= ", {$userId} ";
                $query .= ")";
        
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    // error of sorts
                }
               
                // if all successful, take user back to index.php
                $_SESSION['user']['email']=$safeEmail;
                $_SESSION["successMessage"] = "You have successfully created an account. Please login below.";
                redirectTo("index.php");
                
            } //end if(!foundEmail) 
            else {
                $errorMessage = "User already exists";
            }
        } 
    } else {
        if (isset($_GET["name"]) && isset($_GET["email"])){
            $name = $_GET["name"];
            $email = $_GET["email"];
            $errorMessage = "";
			$question1 = "";
			$question2 = "";
			$question3 = "";
			$question4 = "";
			$answer1 = "";
			$answer2 = "";
			$answer3 = "";
			$answer4 = "";
			
        } else {
            redirectTo("index.php");
        }
    }
?>

<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - SignUp</title>
	
	<!-- Font/s imported here - JK -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	
	<!-- Global stylesheet is imported here - JK -->
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	
	<!-- Global JavaScript is imported here - JK -->
	<script src="javascripts/scripts.js"></script>
	
	<!--Link to Favourite icon ---------------PP -->
	<link rel="shortcut icon" href="images/icons/favicon.ico" />
</head>

<body>
    <?php include_once('../passFree/includes/header.php'); ?>
    <main>
        <!-- PAGE SPECIFIC CONTENT GOES HERE -->
        <form id='signup' action="sign_up.php" method="POST" onsubmit="return checkSignupForm();">
                <div id='userError' class='error'><?php echo htmlentities($errorMessage); ?></div>
            <div>
                <input id="signname" type="text" name="name" value="<?php echo htmlentities($name);?>" placeholder='Enter your name'/ onchange='checkNameInput(this); clearUserError();'>
                    <p class='case'>*this field is case sensitive.</p>
                    <div class='error'></div>
                <input id="signemail" type="text" name="email" value="<?php echo htmlentities($email);?>" placeholder='Enter your email'/ onchange='checkEmailInput(this); clearUserError();'>
                    <div class='error'></div>
            </div>
            
            <button type='button' onclick="examples()">Example Questions</button>
<!--            <a href='exampleqs.php'><button type='button'>Example Questions</button></a>    -->
            
            <div>
                <fieldset><legend>Question 1</legend>
                <input id="question1" type="text" name="question1" value="<?php echo htmlentities($question1);?>" placeholder='Enter your own question 1'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer1" type="text" name="answer1" value="<?php echo htmlentities($answer1);?>" placeholder='Enter your own answer 1' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
                <fieldset><legend>Question 2</legend>
                <input id="question2" type="text" name="question2" value="<?php echo htmlentities($question2);?>" placeholder='Enter your own question 2'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer2" type="text" name="answer2" value="<?php echo htmlentities($answer2);?>" placeholder='Enter your own answer 2' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
                <fieldset><legend>Question 3</legend>
                <input id="question3" type="text" name="question3" value="<?php echo htmlentities($question3);?>" placeholder='Enter your own question 3'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer3" type="text" name="answer3" value="<?php echo htmlentities($answer3);?>" placeholder='Enter your own answer 3' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
                <fieldset><legend>Question 4</legend>
                <input id="question4" type="text" name="question4" value="<?php echo htmlentities($question4);?>" placeholder='Enter your own question 4'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer4" type="text" name="answer4" value="<?php echo htmlentities($answer4);?>" placeholder='Enter your own answer 4' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
            </div>
            
            <button type="submit" name="submit">Sign Up</button>
        </form>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->
    </main>
    <?php include_once('../passFree/includes/footer.php'); ?>
</body>
</html>
<?php
    if(isset($connection)){
        mysqli_close($connection);
    }
?>