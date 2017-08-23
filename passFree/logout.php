<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php loginConfirm()?>

<?php
    if(isset($_SESSION["userID"]) && !empty($_SESSION["userID"])){
        logOut();
    }
?>

<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Log Out</title>
	
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
            <form id='homepage' action="logout.php" method="POST">
                
            <div>Thank you for using PassFree. See you again next time.</div>
                
            <a href='index.php'><button type="button">Login</button></a>
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