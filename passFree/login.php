<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php require_once("../passFree/includes/functions_extended.php"); ?>
<?php require_once("../passFree/includes/validations.php"); ?>

<?php
    //If name and email (session) have been located and set.
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
        $questionArray = array($questions[0]["question"], $questions[1]["question"], 
                    $questions[2]["question"], $questions[3]["question"] );

        if(isset($_POST["submit"])){
            
            //trim answers and concatenate answer 1,2 and answer3,4
            $answer1 = trim($_POST["answer1"]);
            $answer2 = trim($_POST["answer2"]);
            $answer3 = trim($_POST["answer3"]);
            $answer4 = trim($_POST["answer4"]);
            // login answer and key answer cocatenated
            $loginAnswers = $answer1 . $answer2 . $answer3 . $answer4;
            $keyAnswer = $answer3 . $answer4;
            
            
            //query for user's answer.
            $query = "SELECT * ";
            $query .= "FROM answer ";
            $query .= "WHERE user_id = {$userID}; ";
            
            $answerResult = mysqli_query($connection, $query);
            confirmQuery($answerResult);
            
            $answer = mysqli_fetch_assoc($answerResult);

            if(!$answer){
                $errorMessage = "Error retrieving answers!";
                
            }           
            if (checkAnswers($loginAnswers, $answer["hashed_answer"])) {
                
                // if answers are correct, if confirmUserLogin returns 1 (not lockout out), 
                // if returns 0, then account is locked out and returns account locked out error.
                if (confirmUserLogin($userID) == 1)
                {
                    $_SESSION["userID"] = $userID;
                    $_SESSION["userKey"] = $keyAnswer;
                    redirectTo("view_password.php");
                }
                else
                {
                    $errorMessage = "Your account is locked out. Please wait up to 10 minutes and try again.";
                }
            }
            else {
            //if the answers are incorrect, addLoginAttempt($userID) to increment the attempts_counter
            addLoginAttempt($userID);
            $errorMessage = "One or more of the answers were incorrect!";
            }
        } else {
			$errorMessage = "";
		}

    } else {
        redirectTo("index.php");
    }
?>

<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Log In</title>
	
	<!-- Font/s imported here - JK -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	
	<!-- Global stylesheet is imported here - JK -->
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	
	<!-- Global JavaScript is imported here - JK -->
	<script src="javascripts/scripts.js"></script>
	
	<!--Link to Favourite icon ---------------PP -->
	<link rel="shortcut icon" href="images/icons/favicon.ico" />
	
	<!-- viewport for responsive sizing on different platforms-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    
    <!-- HEADER -->
    <?php include_once('../passFree/includes/header.php'); ?>
    
    <main>
        <!-- PAGE SPECIFIC CONTENT GOES HERE -->
            <form id='login' action="login.php" method="POST">
                <div id='userError' class='error'><?php echo htmlentities($errorMessage); ?></div>
                
            <!-- DISPLAY USER NAME -->
            <div id="spacing">Welcome back, <?php echo htmlentities(ucwords($name)); ?> </div>
            
            <!-- DISPLAY LAST LOGIN DATE -->
            <div id="lastLog"></div>
            
            <br>
            
            <!-- DISPLAY QUESTION 1 -->
            <div id="question1"> <?php echo htmlentities($questionArray[0]); ?></div>
            <input class='loginanswer' id="answer1" type="text" name="answer1"  value="" placeholder='Enter answer'>
                <p class='case'>this field is case sensitive.</p>
                <div class='error'></div>
            
            <!-- DISPLAY QUESTION 2 -->
            <div id="question2"> <?php echo htmlentities($questionArray[1]); ?></div>
            <input id="answer2" type="text" name="answer2"  value="" placeholder='Enter answer'>
                <p class='case'>this field is case sensitive.</p>
                <div class='error'></div>
            
            <!-- DISPLAY QUESTION 3 -->
            <div id="question3"> <?php echo htmlentities($questionArray[2]); ?></div>
            <input id="answer3" type="text" name="answer3"  value="" placeholder='Enter answer'>
                <p class='case'>this field is case sensitive.</p>
                <div class='error'></div>
                
            <!-- DISPLAY QUESTION 4 -->
            <div id="question4"> <?php echo htmlentities($questionArray[3]); ?></div>
            <input id="answer4" type="text" name="answer4"  value="" placeholder='Enter answer'>
                <p class='case'>this field is case sensitive.</p>
                <div class='error'></div>
                
            <button type="submit" name="submit">View Passwords</button>
            
        </form>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->
    </main>
        
    <!-- FOOTER -->
    <?php include_once('../passFree/includes/footer.php'); ?>
    
</body>
</html>
<?php
    if(isset($connection)){
        mysqli_close($connection);
    }
?>