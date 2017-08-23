<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
	
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
    <header>
        Login
        <!-- Navigation bar is imported here - JK -->
        <?php include_once('includes/navbar.php'); ?>
    </header>
    
    <main>
        <!-- PAGE SPECIFIC CONTENT GOES HERE -->
        
        <!-- Testing Styling - delete later -->
        
        
        
        <form>
            <input type="text" name="name" placeholder='Enter your name'/ required>
            <input type="text" name="email" placeholder='Enter your email'/ required>
            <button type='submit' value='Submit'>Login</button>
            <button>Free to Sign Up</button>
        </form>

    </main>
    <footer>
        <!-- import contact details, etc here? - JK -->
    </footer>
</body>
</html>