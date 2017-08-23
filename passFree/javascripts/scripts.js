/* Testing Area */

/* End of Testing Area */



// List of words that are not allowed in a question
var genericWords = ["boyfriend","girlfriend","phone number","phone no","actor",
"movie","film","musician","band","author","artist","pet","pets","pet's","high school",
"primary school","school","movie","book","maiden","teacher","birthplace",
"birth place","home town"];



// Generic function to add an Error Message to an element.
function printError(element, errorMsg) {
    element.innerHTML = errorMsg;
}



// Generic function to save typing getElementById all the time
function gebi(id) {
    return document.getElementById(id);
}



// Function to check a string has at least 2 characters and no numbers. 
// Returns true if string is ok. False if doesn't pass tests.
function checkName(string) {
    var len = 2;
    var hasNumber = /\d/;
    return !(string.length < len || hasNumber.test(string));
}



// Function to test name input field.
// If it does not pass the test, an error message is passed to the next element
function checkNameInput(input) {
    var errorMsg = "Please enter valid name.";
    if (checkName(input.value)) {
        printError(input.nextElementSibling, "");
    }
    else printError(input.nextElementSibling, errorMsg);
}



// Function to check a string is a valid email and is 255 or less characters.
// Returns true if string is ok. False if doesn't pass tests.
function checkEmail(string) {
    /* Regex sourced and adopted from  http://www.w3resource.com/javascript/form/email-validation.php
    for educational purposes only */
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return (regex.test(string) && string.length < 256);
}



// Function to check the email input is valid.
// If it does not pass the test, an error message is passed to the next element
function checkEmailInput(input) {
    var errorMsg = "Please enter valid email address.";
    if (!checkEmail(input.value)) {
        printError(input.nextElementSibling, errorMsg);
    }
    else printError(input.nextElementSibling, "");
}



// Checks a string to see if it has any of the full generic words in it (not case senstive)
function checkQuestion(string) {
    if (string.length == 0) {
        return false;
    }
    for (var i = 0; i < genericWords.length; i++) {
        // Checks only for full words in list.. 
        var regex = '\\b';
        regex += genericWords[i];
        regex += '\\b';
        var regexTest = new RegExp(regex, "i");
        if (regexTest.test(string)) {
            return false;
        }
    }
    return true;
}



// Function to test if an input value contains word/s that are too generic
function checkQuestionInput(input) {
    var string = input.value;
    var errorMsg1 = "Warning! This looks like a question that could easily be guessed. Please pick another.";
    var errorMsg2 = "Error! Please enter question with at least 5 characters.";
    if (checkQuestion(string) && string.length > 4) {
        printError(input.nextElementSibling, "");
    } else if (string.length < 5) {
        printError(input.nextElementSibling, errorMsg2);
    } else {
        printError(input.nextElementSibling, errorMsg1);
    }
}



// Function to test that there is an answer input
function checkAnswerInput(input) {
    var string = input.value;
    var errorMsg = "Error! Please enter answer with at least 5 characters.";
    if (checkAnswer(string)) {
        printError(input.nextElementSibling, "");
    } else {
            printError(input.nextElementSibling, errorMsg);
    }
}



function checkAnswer(string) {
    return (string.length > 4);
}




// Checks login form before allowing user to submit
function checkLoginForm() {
    var name = gebi("name").value;
    var email = gebi("email").value;
    if (checkName(name) && checkEmail(email)) {
        document.forms['homepage'].submit();
    } else {
        alert("Please enter valid name and email address.");
        return false;
    }
}


// Checks the question form before submission
function checkSignupForm() {
    // Not very elegant, might change later
    var name = gebi("signname").value;
    var email = gebi("signemail").value;
    var q1 = gebi("question1").value;
    var q2 = gebi("question2").value;
    var q3 = gebi("question3").value;
    var q4 = gebi("question4").value;
    var a1 = gebi("answer1").value;
    var a2 = gebi("answer2").value;
    var a3 = gebi("answer3").value;
    var a4 = gebi("answer4").value;
    
    if (checkName(name) && checkEmail(email) && checkQuestion(q1) && checkQuestion(q2) && checkQuestion(q3) && checkQuestion(q4) && checkAnswer(a1) && checkAnswer(a2) && checkAnswer(a3) && checkAnswer(a4)) {
        document.forms['signup'].submit();
    } else {
        alert("Please check errors and resubmit.");
        return false;
    }
}



// Clears 'Unknown User' error
function clearUserError() {
    gebi('userError').innerHTML = "";
}



// Advises user of example questions
function examples() {
    alert("Your questions need to be relativity easy for you to answer but almost impossible for someone else "+
            "to guess.\n\nExamples of what questions to enter....\nWhat was the first song that I heard when "+
            "I met my wife?\nWhat was my first memory?\nWhat was my kindergartens room name?\n\n"+
            "Examples of what not to ask?\nWhat is my dogs name?\nWhat is my mothers maiden name?\n"+
            "How many children do I have?\n\nRemember, the more obscure the question is and the longer "+
            "the answer, the harder it will be for people to get your passwords!");
}