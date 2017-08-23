<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php require_once("../passFree/includes/validations.php"); ?>

<?php
//set name and email to blank
$name = "";
$email = "";

//if (isset($_SESSION['user']['email'])) {
//	echo "<p>logged in path</p>";
//} // else {

// displays success message then clears it
if (isset($_SESSION["successMessage"])) {
	$successMessage = $_SESSION["successMessage"];
	$_SESSION["successMessage"] = "";
} else {
	$successMessage = "";
}

// check and validate user's submitted input
if(isset($_POST["submit"]) && isset($_POST["name"]) && isset($_POST["email"])){
	
	// set name and email to input
	$name = $_POST["name"];
	$email = $_POST["email"];
	
	// calls function to check on name input, parameters are inputsArray() and errorArray() and returned is errorArray()
	validateName($name);
	
	// calls function to check on email input, parameters are inputsArray() and errorArray() and returned is errorArray()
	validateEmail($email);
	
	if (sizeof($errorArray) == 0) {
		$foundUser = checkUserExists($name, $email);
		if ($foundUser) {
			// Successfully found. Redirect to secret answers page.
			// Does not populate user_id into session until secret answers are correct.
			$_SESSION["name"] = $foundUser["name"];
			$_SESSION["email"] = $foundUser["email"];
			redirectTo("login.php");
		}
		else {
        	$errorArray["login"] = "User input error";
        	$errorArray["name"] = "";
			$errorArray["email"] = "";
        }	
	}
} else {
	$errorArray["login"] = "";
	$errorArray["name"] = "";
	$errorArray["email"] = "";
}
	
?>


<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Homepage</title>
	
	<!-- Fonts imported here - JK -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	
	<!-- Global stylesheet is imported here - JK -->
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	
	<!-- Global JavaScript is imported here - JK -->
	<script src="javascripts/scripts.js"></script>
	
	<!--Link to Favourite icon PP -->
	<link rel="shortcut icon" href="images/icons/favicon.ico" />
</head>

<body id='login'>
    <a href='about.php'><img src="images/logo/passFreeLogo_medium.png" ></a>
    <main>
        <!-- PAGE SPECIFIC CONTENT GOES HERE -->
	<?php 
	if ( loggedIn() ){
		echo "<p>You are currently logged in!</p>";
		echo "<a href='view_password.php'><button type='button'>Enter</button></a>";
		echo "<a href='logout.php'><button type='button'>Log Out</button></a>";
	} else {
		require_once("../passFree/includes/login_form.php");
	}
	?>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->
    
    </main>
</body>
</html>
<?php
    if(isset($connection)){
        mysqli_close($connection);
    }
?>