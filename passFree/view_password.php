<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php loginConfirm()?>
<?php require_once("../passFree/includes/retrieve_password.php"); ?>
<?php
    if (isset($_SESSION["successMessage"])) {
        $successMessage = $_SESSION["successMessage"];
        $_SESSION["successMessage"] = "";
    } else {
        $successMessage = "";
    }
?>

<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - View Passwords</title>
	
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
        <form id='view' action="view.php" method="POST">
            <div id='successMessage' class='success'><?php echo htmlentities($successMessage); ?></div>
            
            <!-- DISPLAY PASSWORD INPUT FROM TEXTAREA -->
            <fieldset class='display'><legend>View Passwords</legend>
            <div id="display">
                <?php echo nl2br(htmlentities($decryptedPassword));?>
            </div>
            </fieldset>
            
            <button type="submit" name="pwordEd" formaction="edit_password.php" method="POST">Edit Passwords</button>
            <button type="submit" name="editQs" formaction="edit_questions.php" method="POST">Edit Questions</button>
            <button type="submit" name="logout" formaction="logout.php" method="POST">Log Out</button>
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