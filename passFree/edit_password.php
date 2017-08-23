<?php require_once("../passFree/includes/session.php"); ?>
<?php require_once("../passFree/includes/dbConnection.php"); ?>
<?php require_once("../passFree/includes/functions.php"); ?>
<?php loginConfirm()?>

<?php
    if(isset($_POST["submit"]) && isset($_POST["editPassword"])){
        $userID = $_SESSION["userID"];
        $passwordData = $_POST["editPassword"];
        
        // openssl variables
        $key = $_SESSION["userKey"];
        $method = "aes-256-ctr";
        $iv_num_bytes = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_num_bytes);
        $options = OPENSSL_RAW_DATA;

        // openssl_encyrpt using previous defined method and options
        $encryptedPassword = encryptPassword($passwordData,$method, $key, $iv);
        
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

        $result = mysqli_query($connection, $query);
        if (!$result) {
            // error of sorts
        }
       
        // if all successful, take user back to index.php
        redirectTo("view_password.php");
    } else {
        $errorMessage = "";
        require_once("../passFree/includes/retrieve_password.php");
    }    
?>


<!DOCTYPE html>
<html id='homepage'>
<head>
    <title>PassFree - Edit Passwords</title>
	
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
        <form id='passwordForm' action="edit_password.php" method="POST">
            <div id='userError' class='error'><?php echo htmlentities($errorMessage); ?></div>
            <textarea id="pwordEd" name="editPassword" rows="24" cols="100"><?php echo htmlentities(trim($decryptedPassword));?>
            </textarea>
            <button type="submit" name="cancel" formaction="view_password.php" method="POST">Cancel</button>
            <button type="submit" name="submit">Done</button>
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