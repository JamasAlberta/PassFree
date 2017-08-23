<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - About PassFree</title>
	
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
            <form id='about' action="logout.php" method="POST">
               
            <div>PassFree is the latest system to access passwords from anywhere in the world.</div>
            <div>Our encryption methods keep your passwords safe from thieves.</div>
            <div>PassFree was designed for easy use with a series of personal questions to be answered, both to make your password list and retrieve it.</div>
            <div>Give it a try for yourself! It is a free program and will always remain free.</div>
            
            
            <a href='index.php'><button type="button">Go back</button></a>
        </form>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->
    </main>
        
    <!-- FOOTER -->
    <?php include_once('../passFree/includes/footer.php'); ?>
    
</body>
</html>