<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php require_once("../passFree/includes/validations.php"); ?>
<?php loginConfirm()?>
<?php require_once("../passFree/includes/retrieve_password.php"); ?>
<?php

 
 //If name and email (session) have been located and set.
 $errorMessage = "";
    if (isset($_SESSION["name"]) && isset($_SESSION["email"])) {
        
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        
        //retrieve and store userID locally
        $user = findUserByEmail($email);
        $userID = $user["user_id"];
        
        // questions to display
        $query = "SELECT * ";
        $query .= "FROM question ";
        $query .= "WHERE user_id = {$userID} ";
        $query .= "ORDER BY question_id ASC ;";
        
        // query for questions, fetching all results and storing in question array.
        $questionResult = mysqli_query($connection, $query);
        confirmQuery($questionResult);
        $questions = mysqli_fetch_all($questionResult, MYSQLI_ASSOC);
        $oldQuestionArray = array($questions[0]["question"], $questions[1]["question"], $questions[2]["question"], $questions[3]["question"]);
        $oldQuestionIdArray = array($questions[0]["question_id"], $questions[1]["question_id"], $questions[2]["question_id"], $questions[3]["question_id"]);
        
        // updates stored records
        if(isset($_POST["submit"])) {
            $question1 = prepMysql($_POST["question1"]);
            $question2 = prepMysql($_POST["question2"]);
            $question3 = prepMysql($_POST["question3"]);
            $question4 = prepMysql($_POST["question4"]);
            $answer1 = trim($_POST["answer1"]);
            $answer2 = trim($_POST["answer2"]);
            $answer3 = trim($_POST["answer3"]);
            $answer4 = trim($_POST["answer4"]);
            $newQuestions = array($question1, $question2, $question3, $question4);
            $newAnswers = array($answer1, $answer2, $answer3, $answer4);
            if (!checkQuestionArray($newQuestions) || !checkAnswerArray($newAnswers)) {
                $errorMessage = "Error! Please ensure all questions and answers are at least 5 characters long.";
            } else {
                // new questions are updated over old ones in database
                for ($i = 0; $i < count($newQuestions); $i++) {
                    $query  = "UPDATE question SET question=";
                    $query .= "'{$newQuestions[$i]}'";
                    $query .= " WHERE question_id = ";
                    $query .= "{$oldQuestionIdArray[$i]}";
                    
                    // and just to make sure it's the right user
                    $query .= " AND user_id = {$userID};";
                    
                    // write to DB
                    $result = mysqli_query($connection, $query);
                    if (!$result) {
                        // error
                    }
                }
                
                
                // concatenate answer1,2,3,4 together
                $answers = $answer1 . $answer2 . $answer3 .$answer4;
                $hash = encryptAnswers($answers);
                
                // query to insert hashed answers into database
                $query  = "UPDATE answer SET hashed_answer=";
                $query .= "'{$hash}'";
                $query .= " WHERE user_id=";
                $query .= "{$userID};";
                
                //echo $query;
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    // error of sorts
                    
                }
                
                // openssl variables
                $key = $answer3 . $answer4;
                $method = "aes-256-ctr";
                $iv_num_bytes = openssl_cipher_iv_length($method);
                $iv = openssl_random_pseudo_bytes($iv_num_bytes);
                $options = OPENSSL_RAW_DATA;
        
                // openssl_encyrpt using previous defined method and options
                $encryptedPassword = encryptPassword($decryptedPassword,$method, $key, $iv);
                
                // base64 encode results for storage in database.
                $encryptedPasswordEncoded = base64_encode($encryptedPassword);
                $ivEncoded  = base64_encode($iv);
                
                // query to create a saved_password field for new user
                $query  = "UPDATE saved_password ";
                $query .= "SET encrypted_password = ";
                $query .= "'{$encryptedPasswordEncoded}', ";
                $query .= "encrypt_iv = ";
                $query .= "'{$ivEncoded}' ";
                $query .= "WHERE user_id = "; 
                $query .= "{$userID}; ";
        
                // update session key
                 $keyAnswer = $answer3 . $answer4;
                 $_SESSION["userKey"] = $keyAnswer;
        
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    // error of sorts
                }
                
                // Success message is created and user is redirected back to menu
                $_SESSION["successMessage"] = "Success! You have updated your secret questions/answers!";
                redirectTo('view_password.php');
            }
        }
    }
?> 

<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Edit Questions</title>
	
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
        
        <form id="editqs" action="edit_questions.php" method="POST" onsubmit="return checkSignupForm();">
            <div id='userError' class='error'><?php echo htmlentities($errorMessage); ?></div>
                <fieldset><legend>Question 1</legend>
                <input id="question1" type="text" name="question1" value="<?php echo htmlentities($oldQuestionArray[0]);?>" placeholder='Enter your own question 1'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer1" type="text" name="answer1" placeholder='Enter your own answer 1' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
                <fieldset><legend>Question 2</legend>
                <input id="question2" type="text" name="question2" value="<?php echo htmlentities($oldQuestionArray[1]);?>" placeholder='Enter your own question 2'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer2" type="text" name="answer2" placeholder='Enter your own answer 2' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
                <fieldset><legend>Question 3</legend>
                <input id="question3" type="text" name="question3" value="<?php echo htmlentities($oldQuestionArray[2]);?>" placeholder='Enter your own question 3'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer3" type="text" name="answer3" placeholder='Enter your own answer 3' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
                <fieldset><legend>Question 4</legend>
                <input id="question4" type="text" name="question4" value="<?php echo htmlentities($oldQuestionArray[3]);?>" placeholder='Enter your own question 4'  onchange='checkQuestionInput(this);'>
                    <div class='error'></div>
                <input id="answer4" type="text" name="answer4" placeholder='Enter your own answer 4' onchange='checkAnswerInput(this);'>
                    <div class='error'></div>
                    <div class='casea'>this field is case sensitive.</div>
                </fieldset>
            <button type="submit" name="submit">Save Changes</button>
            <button name="back" formaction="view_password.php">Back to Menu</button>
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