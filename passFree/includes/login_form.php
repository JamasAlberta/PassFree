   <p>Welcome to PassFree. Please login or sign up below.</p>  
    <div id='successMessage' class='success'><?php echo htmlentities($successMessage); ?></div>
        <form id='homepage' action="index.php" method="POST" onsubmit="return checkLoginForm();">
                <div id='userError' class='error'><?php echo htmlentities($errorArray["login"]); ?></div>
            <input id="name" type="text" name="name" value="<?php echo htmlentities($name);?>" placeholder='Enter your name' onchange='checkNameInput(this); clearUserError();'>
                <div class='error'><?php echo htmlentities($errorArray["name"]); ?></div>
                <div class='case'>this field is case sensitive.</div>
            <input id="email" type="text" name="email" value="<?php echo htmlentities($email);?>" placeholder='Enter your email' onchange='checkEmailInput(this); clearUserError();'>
                <div class='error'><?php echo htmlentities($errorArray["email"]); ?></div>
            <button type="submit" name="submit">Login</button>
            <button type="submit" name="submit" formaction="sign_up.php" formmethod="GET">Sign Up for Free</button>
        </form>
    <p id="nostyle">Click the logo to learn more about PassFree - the newest way to store and retreive your passwords.</p>
        <!-- PAGE SPECIFIC CONTENT ENDS HERE -->