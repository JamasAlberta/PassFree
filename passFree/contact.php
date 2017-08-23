<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>

<?php
    // check whether user came here from a logged in page.
    if(isset($_POST["submit"])){
        if(loggedIn()){
            redirectTo("view_password.php");
        }
        else {
            redirectTo("index.php");
        }
    }    
?>        

<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Contact Details</title>
	
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
            <form id='contact' action="contact.php" method="POST">
                
                <div>The contents of this website are protected by copyright law. Copyright in this material resides with the
                PassFree or various other rights holders, as indicated.
                    <p>To contact passFree please email below</p>
                    <div class='spacing'>
                        <p id='nostyle'>Jared Kelly  Locale : Brisbane, Australia</p>
                        <p id='nostyle'>Email Address : s3597960@student.rmit.edu.au</p>
                    </div>
                    <div class='spacing'>
                        <p id='nostyle'>Paolo Patti Locale : Brisbane, Australia</p>
                        <p id='nostyle'>Email Address :  s3612331@student.rmit.edu.au</p>
                    </div>
                    <div class='spacing'>
                        <p id='nostyle'>Shanna Roper Locale : Sydney, Australia</p>
                        <p id='nostyle'>Email Address : s3609556@student.rmit.edu.au</p>
                    </div>
                    <div class='spacing'>
                        <p id='nostyle'>James Adams Locale : Brisbane, Australia</p>
                        <p id='nostyle'>Email Address : s3562715@student.rmit.edu.au</p>
                    </div>
                    <div class='spacing'>
                        <p id='nostyle'>Edward Walker Locale : Sydney, Australia</p>
                        <p id='nostyle'>Email Address :  S3613038@student.rmit.edu.au</p>
                    </div>
                </div>
                <button type="submit" name="submit">OK, I've got it</button>
            </form>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->
    </main>
        
    <!-- FOOTER -->
    <?php include_once('../passFree/includes/footer.php'); ?>
    
</body>
</html>