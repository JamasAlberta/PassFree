<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Example</title>
	
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
            <form id='example' action="logout.php" method="POST">
                <div id='userError' class='error'><?php echo htmlentities($errorMessage); ?></div>
                
            <div>Think Long and hard about the question your are going to enter into Pass Free. They need to be relativity easy questions that you
            <span>can answer but almost impossible for someone else to guess</span>
            
            <span>Examples of what questions to enter....</span>
            <span>What was the first song that I heard when I met my wife?</span>
            <span>What was my first memory?</span>
            <span>What was my kindergartens room name?</span>
            
            <span>Examples of what not to ask?</span>

            <span>What is my dogs name?</span>
            <span>What is my mothers maiden name?</span>
            <span>How many children do I have?</span>
            
            <span>Remember the more obscure the question is and the longer the answer the harder it will be for people to get your passwords!</span>
            </div>
                
            <a href='sign_up.php'><button type='button'>Go back</button></a>
        </form>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->
    </main>
        
    <!-- FOOTER -->
    <?php include_once('../passFree/includes/footer.php'); ?>
    
</body>
</html>